<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tabungan;
use App\Models\GroupTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupRoomController extends Controller
{
    /**
     * NOTE:
     * Controller ini isinya sudah campur (contributions + transaksi + edit room).
     * Aku rapihin aja biar jalan sesuai kode kamu sekarang.
     */

    public function index()
{
    $user = Auth::user();

    $rooms = $user->rooms()
        ->with(['tabungan'])
        ->withCount('users')
        ->orderBy('nama_room')
        ->get();

    return view('group.my-rooms', compact('rooms'));
}

    public function transaction(Room $room, Request $request)
    {
        // optional security
        abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

        $type = $request->query('type', 'saving');
        return view('group.transaction', compact('room', 'type'));
    }

    public function storeSpend(Request $request, Room $room)
    {
        abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

        $validated = $request->validate([
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $room) {

            GroupTransaksi::create([
                'room_id'       => $room->id,
                'user_id'       => Auth::id(),
                'tgl_transaksi' => now()->toDateString(),
                'jenis'         => 'spend',
                'nominal'       => (int) $validated['nominal'],
                'keterangan'    => $validated['keterangan'] ?? null,
            ]);

            // ✅ tabungan untuk progress harus tabungan tabungan room
            $tabungan = Tabungan::firstOrCreate(
                ['room_id' => $room->id, 'user_id' => $room->user_id],
                ['target_tabungan' => 0, 'total_terkumpul' => 0, 'status' => 'active']
            );

            $tabungan->increment('total_terkumpul', (int) $validated['nominal']);
        });

        // ✅ balik ke contribution
        return redirect()->route('group.contributions')->with('success', 'Saving berhasil!');
    }

    public function storeWithdraw(Request $request, Room $room)
    {
        abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

        $validated = $request->validate([
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $room) {

            GroupTransaksi::create([
                'room_id'       => $room->id,
                'user_id'       => Auth::id(),
                'tgl_transaksi' => now()->toDateString(),
                'jenis'         => 'withdraw',
                'nominal'       => (int) $validated['nominal'],
                'keterangan'    => $validated['keterangan'] ?? null,
            ]);

            $tabungan = Tabungan::firstOrCreate(
                ['room_id' => $room->id, 'user_id' => $room->user_id],
                ['target_tabungan' => 0, 'total_terkumpul' => 0, 'status' => 'active']
            );

            $tabungan->decrement('total_terkumpul', (int) $validated['nominal']);

            if ($tabungan->total_terkumpul < 0) {
                $tabungan->total_terkumpul = 0;
                $tabungan->save();
            }
        });

        return redirect()->route('group.contributions')->with('success', 'Withdraw berhasil!');
    }

    public function edit(Room $room)
    {
        // ✅ load tabungan tabungan + users
        $room->load(['tabungan', 'users']);
        return view('group.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'nama_room'       => 'required|string|max:255',
            'target_tabungan' => 'nullable|string',
            'target_date'     => 'nullable|date', // kalau kolomnya belum ada, hapus ini
        ]);

        $room->update([
            'nama_room' => $request->nama_room,
        ]);

        $target = (int) preg_replace('/[^0-9]/', '', (string) $request->target_tabungan);

        // ✅ SIMPAN target ke tabungan tabungan room
        $tabungan = Tabungan::firstOrCreate(
            ['room_id' => $room->id, 'user_id' => $room->user_id],
            ['target_tabungan' => 0, 'total_terkumpul' => 0, 'status' => 'active']
        );

        $tabungan->target_tabungan = $target;

        // kalau memang ada kolom target_date di DB
        if ($request->filled('target_date') && \Schema::hasColumn('tabungans', 'target_date')) {
            $tabungan->target_date = $request->target_date;
        }

        $tabungan->save();

        return redirect()->route('group.rooms')->with('success', 'Room updated!');
    }
public function destroy(Room $room)
{
    // hanya owner room yang boleh hapus
    if ((int) $room->user_id !== (int) Auth::id()) {
        abort(403);
    }

    DB::transaction(function () use ($room) {

        // hapus transaksi group
        GroupTransaksi::where('room_id', $room->id)->delete();

        // hapus tabungan
        Tabungan::where('room_id', $room->id)->delete();

        // detach semua member
        $room->users()->detach();

        // hapus room
        $room->delete();
    });

    return redirect()
        ->route('group.rooms')
        ->with('success', 'Room berhasil dihapus');
}

    public function show(Room $room)
{
    abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

    $room->load(['tabungan', 'users']);

    $contributions = GroupTransaksi::with('user')
        ->where('room_id', $room->id)
        ->where('jenis', 'spend') // deposit/saving
        ->latest()
        ->get();

    return view('group.room-detail', compact('room', 'contributions'));
}



public function store(Request $request)
{
    $request->validate([
        'nama_room' => 'required|string|max:255',
        'jenis_room' => 'nullable|string',
        'target_tabungan' => 'nullable|numeric|min:0',
    ]);

    // generate kode unik
    do {
        $kode = strtoupper(Str::random(6));
    } while (Room::where('kode_room', $kode)->exists());

    $room = Room::create([
        'nama_room'  => $request->nama_room,
        'kode_room'  => $kode,              // ✅ WAJIB
        'jenis_room' => $request->jenis_room ?? 'Monthly',
        'user_id'    => Auth::id(),
    ]);

    $room->users()->attach(Auth::id());

    Tabungan::create([
        'room_id'         => $room->id,
        'user_id'         => Auth::id(),
        'target_tabungan' => (int) ($request->target_tabungan ?? 0),
        'total_terkumpul' => 0,
        'status'          => 'active',
    ]);

    return redirect()->route('group.rooms')->with('success', 'Room created!');
}

}

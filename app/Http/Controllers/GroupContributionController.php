<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tabungan;
use App\Models\GroupTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupContributionController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $rooms = $user->rooms()
    ->with('tabungan')   // 🔥 INI PENTING
    ->withCount('users')
    ->orderBy('nama_room')
    ->get();


    $roomIds = $rooms->pluck('id')->all();

    $roomStats = [];
    if (!empty($roomIds)) {
        $myAgg = GroupTransaksi::select(
                'room_id',
                DB::raw("SUM(CASE WHEN jenis='spend' THEN nominal ELSE 0 END) AS my_spend"),
                DB::raw("SUM(CASE WHEN jenis='withdraw' THEN nominal ELSE 0 END) AS my_withdraw")
            )
            ->where('user_id', $user->id)
            ->whereIn('room_id', $roomIds)
            ->groupBy('room_id')
            ->get()
            ->keyBy('room_id');

        foreach ($rooms as $room) {
            $m = $myAgg[$room->id] ?? null;
            $mySpend = (int) ($m->my_spend ?? 0);
            $myWithdraw = (int) ($m->my_withdraw ?? 0);

            $roomStats[$room->id] = [
                'contribution' => $mySpend,
                'balance'      => max(0, $mySpend - $myWithdraw),
            ];
        }
    }

    $totalContribution = (int) GroupTransaksi::where('user_id', $user->id)
        ->where('jenis', 'spend')
        ->sum('nominal');

    $totalWithdraw = (int) GroupTransaksi::where('user_id', $user->id)
        ->where('jenis', 'withdraw')
        ->sum('nominal');

    return view('group.contributions', [
        'rooms' => $rooms,
        'roomStats' => $roomStats,
        'totalContribution' => $totalContribution,
        'totalWithdraw' => $totalWithdraw,
        'activeRooms' => $rooms->count(),
    ]);
}


    public function transaction(Room $room, Request $request)
    {
        abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

        $type = $request->query('type', 'saving');
        return view('group.transaction', compact('room', 'type'));
    }

    public function storeSpend(Request $request, Room $room)
    {
        abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

        $validated = $request->validate([
            'nominal'    => 'required|numeric|min:1',
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

            // ✅ tabungan selalu milik tabungan room
            $tabungan = Tabungan::firstOrCreate(
                ['room_id' => $room->id, 'user_id' => $room->user_id],
                ['target_tabungan' => 0, 'total_terkumpul' => 0, 'status' => 'active']
            );

            $tabungan->increment('total_terkumpul', (int) $validated['nominal']);
        });

        return redirect()->route('group.contributions')->with('success', 'Saving berhasil!');
    }

    public function storeWithdraw(Request $request, Room $room)
    {
        abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

        $validated = $request->validate([
            'nominal'    => 'required|numeric|min:1',
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

    // ⚠️ sebenernya ini taruh di GroupRoomController ya,
    // tapi aku rapihin biar kalau kamu tetap pakai di sini juga jalan.
    public function update(Request $request, Room $room)
{
    $request->validate([
        'nama_room' => 'required|string|max:255',
        'target_tabungan' => 'nullable|string',
        'target_date' => 'nullable|date',
    ]);

    // update nama room
    $room->update([
        'nama_room' => $request->nama_room,
    ]);

    // ambil angka murni dari "Rp 5.000.000"
    $target = (int) preg_replace('/[^0-9]/', '', (string) $request->target_tabungan);

    // SIMPAN / UPDATE TABUNGAN (punya tabungan ROOM)
    $room->tabungan()->updateOrCreate(
        [
            'room_id' => $room->id,
            'user_id' => $room->user_id, // tabungan room
        ],
        [
            'target_tabungan' => $target,
            'total_terkumpul' => $room->tabungan()
                ->where('user_id', $room->user_id)
                ->value('total_terkumpul') ?? 0,
            'status' => 'active',
        ]
    );

    return redirect()
        ->route('group.rooms')
        ->with('success', 'Room updated!');
}

}

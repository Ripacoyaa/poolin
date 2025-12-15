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
    /* =======================
     | LIST ROOM USER
     ======================= */
    public function index()
    {
        $rooms = Auth::user()->rooms()
            ->with('tabungan')
            ->withCount('users')
            ->orderBy('nama_room')
            ->get();

        return view('group.my-rooms', compact('rooms'));
    }

    public function show(Room $room)
{
    abort_unless(Auth::user()->rooms()->whereKey($room->id)->exists(), 403);

    $room->load(['tabungan', 'users']);

    $contributions = GroupTransaksi::with('user')
        ->where('room_id', $room->id)
        ->where('jenis', 'spend')
        ->latest()
        ->get();

    return view('group.room-detail', compact('room', 'contributions'));
}


    /* =======================
     | FORM JOIN
     ======================= */
    public function joinForm()
    {
        return view('group.join');
    }

    /* =======================
     | JOIN ROOM (POST)
     ======================= */
 public function join(Request $request)
{
    $request->validate([
        'kode_room' => 'required|string'
    ]);

    $room = Room::where('kode_room', $request->kode_room)->first();

    if (!$room) {
        return back()->withErrors([
            'kode_room' => 'Kode room tidak ditemukan'
        ]);
    }

    // cek sudah join atau belum
    if ($room->users()->where('user_id', Auth::id())->exists()) {
        return redirect()->route('group.home')
            ->with('info', 'Kamu sudah join room ini');
    }

    // JOIN KE PIVOT
    $room->users()->attach(Auth::id());

    return redirect()->route('group.home')
        ->with('success', 'Berhasil join room');
}



    /* =======================
     | CREATE ROOM
     ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'nama_room' => 'required|string|max:255',
        ]);

        do {
            $kode = strtoupper(Str::random(6));
        } while (Room::where('kode_room', $kode)->exists());

        DB::transaction(function () use ($request, $kode, &$room) {

            $room = Room::create([
                'nama_room' => $request->nama_room,
                'kode_room' => $kode,
                'user_id'   => Auth::id(),
            ]);

            $room->users()->attach(Auth::id());

            Tabungan::create([
                'room_id' => $room->id,
                'user_id' => Auth::id(),
                'target_tabungan' => 0,
                'total_terkumpul' => 0,
                'status' => 'active',
            ]);
        });

        return view('group.created', compact('room'));
    }

    public function edit(Room $room)
{
    // hanya owner yang boleh edit
    abort_unless($room->user_id === Auth::id(), 403);

    return view('group.edit', compact('room'));
}

public function update(Request $request, Room $room)
{
    abort_unless($room->user_id === Auth::id(), 403);

    $request->validate([
        'nama_room' => 'required|string|max:255',
    ]);

    $room->update([
        'nama_room' => $request->nama_room,
    ]);

    return redirect()
        ->route('group.rooms')
        ->with('success', 'Room berhasil diupdate');
}


}

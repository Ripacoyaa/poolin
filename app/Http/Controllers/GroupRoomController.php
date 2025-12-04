<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupRoomController extends Controller
{
    // STEP 1: pilih Join / Create
    public function choose()
    {
        return view('dashboard.group-choose');
    }

    // FORM CREATE ROOM (tampilan)
    public function createForm()
    {
        return view('dashboard.group-create');
    }

    // PROSES CREATE ROOM
    public function store(Request $request)
    {
        $request->validate([
            'nama_room' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $room = Room::create([
            'user_id'   => Auth::id(),
            'nama_room' => $request->nama_room,
            'deskripsi' => $request->deskripsi,
            'tgl_buat'  => now()->toDateString(),
            'kode_room' => strtoupper(Str::random(6)),  // contoh: A74JD91
        ]);

        return redirect()->route('group.created', $room);
    }

    // TAMPILAN "Room successfully created"
    public function created(Room $room)
    {
        return view('dashboard.group-created', compact('room'));
    }

    // FORM JOIN ROOM
    public function joinForm()
    {
        return view('dashboard.group-join');
    }

    // PROSES JOIN ROOM PAKAI KODE
    public function join(Request $request)
    {
        $request->validate([
            'room_code' => 'required|string',
        ]);

        $room = Room::where('kode_room', $request->room_code)->first();

        if (! $room) {
            return back()->withErrors(['room_code' => 'Kode room tidak ditemukan']);
        }

        // TODO: di sini nanti kamu bisa simpan membership user ke room
        // misal tabel room_user, dsb. Untuk sekarang langsung masuk dashboard room saja.

        return redirect()->route('group.room', $room);
    }

    // DASHBOARD ROOM (placeholder dulu)
    public function room(Room $room)
    {
        return view('dashboard.group-room', compact('room'));
    }
}

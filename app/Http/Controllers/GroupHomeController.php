<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class GroupHomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // sementara: ambil semua room yang dibuat user ini
        // (nanti kalau ada tabel anggota, bisa diganti ke membership)
        $rooms = Room::where('user_id', $user->id)->get();

        // bisa juga hitung total kontribusi dsb kalau mau
        return view('group.home', compact('rooms', 'user'));
    }
}

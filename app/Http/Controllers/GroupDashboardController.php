<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class GroupDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // semua room yang dimiliki user ini (sementara owner aja dulu)
        $rooms = Room::with('tabungans')
            ->where('user_id', $userId)
            ->get();

        // hitung progress per room
        foreach ($rooms as $room) {
            $target    = $room->tabungans->sum('target_tabungan');
            $collected = $room->tabungans->sum('total_terkumpul');

            $room->target_total    = $target;
            $room->collected_total = $collected;
            $room->progress        = $target > 0
                ? min(100, round($collected / $target * 100))
                : 0;
        }

        $totalRooms   = $rooms->count();
        $activeRooms  = $rooms->count(); // sementara semua dianggap active

        // total kontribusi (saving) di semua room user ini
        $roomIds = $rooms->pluck('id');

        $totalContribution = Transaksi::where('jenis', 'saving')
            ->whereHas('tabungan', function ($q) use ($roomIds) {
                $q->whereIn('room_id', $roomIds);
            })
            ->sum('nominal');

        // recent activity (5 transaksi terakhir)
        $recentActivities = Transaksi::with(['tabungan.room'])
            ->whereHas('tabungan', function ($q) use ($roomIds) {
                $q->whereIn('room_id', $roomIds);
            })
            ->orderBy('tgl_transaksi', 'desc')
            ->limit(5)
            ->get();

        return view('group.home', compact(
            'rooms',
            'totalRooms',
            'activeRooms',
            'totalContribution',
            'recentActivities'
        ));
    }
}

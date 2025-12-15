<?php

namespace App\Http\Controllers;

use App\Models\GroupTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupHomeController extends Controller
{
    public function index()
    
    {

        $user = Auth::user();

        // rooms yang user join
       $rooms = Auth::user()->rooms()
    ->with(['tabungan'])
    ->withCount('users')
    ->orderBy('nama_room')
    ->get();


        $roomIds = $rooms->pluck('id');

        $totalRooms  = $rooms->count();
        $activeRooms = $rooms->count(); // kalau kamu punya status room, nanti bisa difilter

        // Contribution bulan ini (spend)
        $contributionThisMonth = (int) GroupTransaksi::whereIn('room_id', $roomIds)
            ->where('jenis', 'spend')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('nominal');

        // Top contributor bulan ini (3 besar)
        $topContributors = GroupTransaksi::with('user:id,name,photo_path')
            ->select('user_id', DB::raw('SUM(nominal) as total'))
            ->whereIn('room_id', $roomIds)
            ->where('jenis', 'spend')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take(3)
            ->get();

        // Recent activity (5 terakhir)
        $recentActivities = GroupTransaksi::with([
                'user:id,name,photo_path',
                'room:id,nama_room'
            ])
            ->whereIn('room_id', $roomIds)
            ->latest()
            ->take(5)
            ->get();

        return view('group.home', compact(
            'totalRooms',
            'activeRooms',
            'contributionThisMonth',
            'rooms',
            'topContributors',
            'recentActivities'
        ));
    }
}

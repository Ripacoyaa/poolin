<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tabungan;
use App\Models\GroupTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class GroupDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1) ambil rooms (sementara: semua room)
        // nanti kalau udah ada join/pivot, ganti jadi rooms yg user join
        $rooms = Room::orderBy('nama_room')->get();

        // 2) angka top cards
        $totalRooms  = $rooms->count();

        $activeRooms = $rooms->where(function ($r) {
            $status = strtolower($r->status ?? 'active');
            return !in_array($status, ['finished','completed']);
        })->count();

        // Contribution "This Month" (spend user bulan ini)
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        $contributionThisMonth = GroupTransaksi::where('user_id', $userId)
            ->where('jenis', 'spend')
            ->whereBetween('created_at', [$start, $end])
            ->sum('nominal');

        // 3) Per-room stats buat "Your Rooms"
        // total spend & withdraw per room (global)
        $sumSpendByRoom = GroupTransaksi::selectRaw('room_id, SUM(nominal) as total')
            ->where('jenis', 'spend')
            ->groupBy('room_id')
            ->pluck('total', 'room_id');

        $sumWithdrawByRoom = GroupTransaksi::selectRaw('room_id, SUM(nominal) as total')
            ->where('jenis', 'withdraw')
            ->groupBy('room_id')
            ->pluck('total', 'room_id');

        // target tabungan per room (dari tabungan)
        $targetByRoom = Tabungan::selectRaw('room_id, MAX(target_tabungan) as target')
            ->groupBy('room_id')
            ->pluck('target', 'room_id');

        $tabunganByRoom = Tabungan::whereIn('room_id', $rooms->pluck('id'))
    ->get()
    ->keyBy('room_id');


        // gabungin jadi array siap render
        $roomCards = $rooms->map(function ($room) use ($tabunganByRoom) {
    $t = $tabunganByRoom->get($room->id);

    $target    = (int) ($t->target_tabungan ?? 0);
    $collected = (int) ($t->total_terkumpul ?? 0);

    $progress = $target > 0 ? min(100, (int) round($collected / $target * 100)) : 0;

    return [
        'room'      => $room,
        'target'    => $target,
        'collected' => $collected,
        'progress'  => $progress,
    ];
});


        return view('group.home', compact(
            'totalRooms',
            'activeRooms',
            'contributionThisMonth',
            'roomCards'
        ));
    }
}

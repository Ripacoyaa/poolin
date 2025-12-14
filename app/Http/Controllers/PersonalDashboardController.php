<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Tabungan;
use Illuminate\Support\Facades\Auth;

class PersonalDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $currentYear = now()->year;

        /*
        |-------------------------------------------------
        | 1. SAVING STREAK = jumlah transaksi nabung user
        |   (hanya tabungan personal: room_id = null)
        |-------------------------------------------------
        */
        $savingStreak = Transaksi::where('user_id', $userId)
            ->where('jenis', 'saving')
            ->whereHas('tabungan', function ($q) {
                $q->whereNull('room_id'); // personal
            })
            ->count();

        /*
        |-------------------------------------------------
        | 2. GOAL HIGHLIGHT = goal dengan progress tertinggi
        |   progress = total nabung (saving) / target_tabungan
        |   hanya tabungan personal (room_id null)
        |-------------------------------------------------
        */
        $goals = Tabungan::where('user_id', $userId)
            ->whereNull('room_id')    // personal
            ->get();

        $goals = $goals->map(function ($goal) use ($userId) {
            $totalSaving = Transaksi::where('user_id', $userId)
                ->where('tabungan_id', $goal->id)
                ->where('jenis', 'saving')
                ->sum('nominal');

            $progress = $goal->target_tabungan > 0
                ? ($totalSaving / $goal->target_tabungan) * 100
                : 0;

            $goal->progress = round($progress);
            return $goal;
        });

        $goalHighlight = $goals->sortByDesc('progress')->first();

        /*
        |-------------------------------------------------
        | 3. NEAREST GOAL = goal personal dengan target_tanggal
        |    terdekat (>= hari ini)
        |-------------------------------------------------
        */
        $nearestGoal = Tabungan::where('user_id', $userId)
            ->whereNull('room_id')                 // personal
            ->whereNotNull('target_tanggal')
            ->whereDate('target_tanggal', '>=', now()->toDateString())
            ->orderBy('target_tanggal')
            ->first();

        /*
        |-------------------------------------------------
        | 4. NEW ACTIVITY = 5 transaksi personal terakhir
        |-------------------------------------------------
        */
        $newActivities = Transaksi::where('user_id', $userId)
            ->whereHas('tabungan', function ($q) {
                $q->whereNull('room_id'); // personal
            })
            ->latest()
            ->take(5)
            ->get();

        /*
        |-------------------------------------------------
        | 5. CHART DATA BULANAN = total nabung per bulan
        |    (tahun berjalan, hanya saving & personal)
        |-------------------------------------------------
        */
        $chartLabels = [];
        $chartData   = [];

        for ($m = 1; $m <= 12; $m++) {
            // label bulan (Jan, Feb, dst)
            $label = date('M', mktime(0, 0, 0, $m, 1));
            $chartLabels[] = $label;

            $sumNominal = Transaksi::where('user_id', $userId)
                ->where('jenis', 'saving')
                ->whereHas('tabungan', function ($q) {
                    $q->whereNull('room_id'); // personal only
                })
                ->whereYear('tgl_transaksi', $currentYear)
                ->whereMonth('tgl_transaksi', $m)
                ->sum('nominal');

            $chartData[] = $sumNominal;
        }

        return view('dashboard.personal', [
            'savingStreak'  => $savingStreak,
            'goalHighlight' => $goalHighlight,
            'nearestGoal'   => $nearestGoal,
            'newActivities' => $newActivities,
            'chartLabels'   => $chartLabels,
            'chartData'     => $chartData,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // filter dari form (nullable)
        $month   = $request->query('month');      // 1-12 atau null
        $year    = $request->query('year');       // 2025, dll
        $goalId  = $request->query('goal_id');    // id tabungan atau 'all'/null

        // daftar goal personal untuk dropdown
        $goals = Tabungan::where('user_id', $userId)
            ->whereNull('room_id')
            ->orderBy('nama')
            ->get();

        // query transaksi user ini (personal saja)
        $txQuery = Transaksi::whereHas('tabungan', function ($q) use ($userId) {
            $q->where('user_id', $userId)->whereNull('room_id');
        });

        if ($month) {
            $txQuery->whereMonth('tgl_transaksi', $month);
        }

        if ($year) {
            $txQuery->whereYear('tgl_transaksi', $year);
        }

        if ($goalId && $goalId !== 'all') {
            $txQuery->where('tabungan_id', $goalId);
        }

        $transactions = $txQuery
            ->orderBy('tgl_transaksi', 'desc')
            ->get();

        // statistik dari transaksi yang sudah difilter
        $totalSavings = $transactions
            ->where('jenis', 'saving')
            ->sum('nominal');

        $totalExpenditure = $transactions
            ->where('jenis', 'withdraw')
            ->sum('nominal');

        // total goal selesai (nggak ikut filter tanggal)
        $totalFinishedGoals = Tabungan::where('user_id', $userId)
            ->whereNull('room_id')
            ->where('status', 'finished')
            ->count();

        // (optional) data per bulan buat grafik sederhana (sum saving tiap bulan)
        // sesuai filter tahun & goal
        $chartData = [];
        if ($year) {
            $monthlyQuery = clone $txQuery;
            $monthly = $monthlyQuery
                ->whereYear('tgl_transaksi', $year)
                ->where('jenis', 'saving')
                ->get()
                ->groupBy(function ($tx) {
                    return $tx->tgl_transaksi->format('n'); // 1..12
                });

            for ($m = 1; $m <= 12; $m++) {
                $chartData[$m] = isset($monthly[$m])
                    ? $monthly[$m]->sum('nominal')
                    : 0;
            }
        }

        return view('dashboard.personal-report', [
            'transactions'       => $transactions,
            'goals'              => $goals,
            'totalSavings'       => $totalSavings,
            'totalExpenditure'   => $totalExpenditure,
            'totalFinishedGoals' => $totalFinishedGoals,
            'month'              => $month,
            'year'               => $year,
            'goalId'             => $goalId,
            'chartData'          => $chartData,
        ]);
    }
}

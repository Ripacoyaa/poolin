<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tabungan;
use App\Models\Transaksi;
use Carbon\Carbon;

class PersonalReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // default = bulan & tahun sekarang
        $month  = $request->filled('month') ? (int) $request->month : (int) now()->month;
        $year   = $request->filled('year')  ? (int) $request->year  : (int) now()->year;
        $goalId = $request->goal_id ?? 'all';

        // =========================
        // GOALS (My Goals)
        // =========================
        $goals = Tabungan::where('user_id', $user->id)->get();

        // Map target by goal ID (lebih aman daripada nama)
        $targetsById = $goals->pluck('target_tabungan', 'id')->map(fn ($v) => (int) $v)->toArray();

        // =========================
        // TRANSACTIONS LIST (table)
        // =========================
        $txQuery = Transaksi::with('tabungan')
            ->where('user_id', $user->id)
            ->whereMonth('tgl_transaksi', $month)
            ->whereYear('tgl_transaksi', $year);

        if ($goalId !== 'all') {
            $txQuery->where('tabungan_id', (int) $goalId);
        }

        $transactions = $txQuery->orderByDesc('tgl_transaksi')->get();

        // =========================
        // TOTAL CARDS
        // =========================
        $totalSavings = (clone $txQuery)->where('jenis', 'saving')->sum('nominal');
        $totalExpenditure = (clone $txQuery)->where('jenis', 'withdraw')->sum('nominal');

        // finished goals (all time)
        $totalFinishedGoals = Tabungan::where('user_id', $user->id)
            ->where('status', 'finished')
            ->count();

        // =========================
        // CHART (Week 1-4 per goal, akumulatif)
        // =========================
        $weekLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];

        // pilih goals untuk chart
        $goalList = ($goalId === 'all')
            ? $goals
            : $goals->where('id', (int) $goalId);

        /**
         * Pakai KEY = goalId (lebih aman), nanti di JS labelnya ambil dari nama
         * $goalSeries: [goalId => ['label' => goalName, 'data' => [w1..w4]]]
         */
        $goalSeries = [];
        foreach ($goalList as $g) {
            $goalSeries[$g->id] = [
                'label' => $g->nama,
                'data'  => [0, 0, 0, 0],
            ];
        }

        // ambil transaksi buat chart (filter sama)
        $txForChart = Transaksi::where('user_id', $user->id)
            ->whereMonth('tgl_transaksi', $month)
            ->whereYear('tgl_transaksi', $year)
            ->when($goalId !== 'all', fn ($q) => $q->where('tabungan_id', (int) $goalId))
            ->get();

        foreach ($txForChart as $t) {
            $goal_id = (int) $t->tabungan_id;

            // kalau goal belum ke-init (misal goal baru/ga masuk goalList), init biar aman
            if (!isset($goalSeries[$goal_id])) {
                $goalName = optional($goals->firstWhere('id', $goal_id))->nama;
                if (!$goalName) continue;

                $goalSeries[$goal_id] = [
                    'label' => $goalName,
                    'data'  => [0, 0, 0, 0],
                ];
            }

            $d = Carbon::parse($t->tgl_transaksi);
            $week = (int) ceil($d->day / 7);     // 1..5
            $weekIndex = min($week, 4) - 1;      // paksa max Week 4 (index 0..3)

            $val = (int) $t->nominal;
            if ($t->jenis === 'withdraw') {
                $val = -$val;
            }

            $goalSeries[$goal_id]['data'][$weekIndex] += $val;
        }

        // running total + CAP target (ini yang bikin gak lewat target)
        foreach ($goalSeries as $gId => $payload) {
            $arr = $payload['data'];

            // running total
            for ($i = 1; $i < 4; $i++) {
                $arr[$i] += $arr[$i - 1];
            }

            // cap supaya tidak lewat target
            $target = (int) ($targetsById[$gId] ?? 0);
            if ($target > 0) {
                for ($i = 0; $i < 4; $i++) {
                    if ($arr[$i] > $target) $arr[$i] = $target;
                }
            }

            $goalSeries[$gId]['data'] = $arr;
        }

        /**
         * Biar view kamu simpel, aku kirim ke blade jadi format:
         * weeklyGoalData = [
         *   ['label'=>'Laptop Baru','data'=>[...]],
         *   ...
         * ]
         */
        $weeklyGoalData = array_values($goalSeries);

        return view('dashboard.personal-report', [
            'month' => $month,
            'year' => $year,
            'goalId' => $goalId,
            'goals' => $goals,

            'transactions' => $transactions,
            'totalSavings' => $totalSavings,
            'totalExpenditure' => $totalExpenditure,
            'totalFinishedGoals' => $totalFinishedGoals,

            'weeklyWeekLabels' => $weekLabels,
            'weeklyGoalData' => $weeklyGoalData,
        ]);
    }
}

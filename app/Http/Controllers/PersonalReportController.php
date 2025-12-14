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
// CHART (Week per goal, akumulatif NET: saving +, withdraw -)
// =========================

// Hitung jumlah minggu dalam bulan tsb (4 atau 5)
$daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
$weeksCount  = (int) ceil($daysInMonth / 7); // 4 atau 5

$weekLabels = collect(range(1, $weeksCount))->map(fn($i) => "Week {$i}")->all();

// pilih goals untuk chart
$goalList = ($goalId === 'all')
    ? $goals
    : $goals->where('id', (int) $goalId);

/**
 * $goalSeries: [goalId => ['label' => goalName, 'data' => [w1..wN]]]
 */
$goalSeries = [];
foreach ($goalList as $g) {
    if (empty($g->nama)) continue; // ✅ cegah label null dari awal

    $goalSeries[$g->id] = [
        'label' => $g->nama,
        'data'  => array_fill(0, $weeksCount, 0),
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
    if (!$goal_id) continue; // biar ga jadi "null" series

    // init goal kalau belum ada (safety)
    if (!isset($goalSeries[$goal_id])) {
        $goalName = optional($goals->firstWhere('id', $goal_id))->nama;
        if (!$goalName) continue;

        $goalSeries[$goal_id] = [
            'label' => $goalName,
            'data'  => array_fill(0, $weeksCount, 0),
        ];
    }

    $d = Carbon::parse($t->tgl_transaksi);
    $week = (int) ceil($d->day / 7);           // 1..5
    $weekIndex = max(1, min($weeksCount, $week)) - 1; // index 0..weeksCount-1

    $val = (int) $t->nominal;

    // NET: saving +, withdraw -
    if (in_array($t->jenis, ['withdraw', 'withdrawn'], true)) {
        $val = -$val;
    }

    $goalSeries[$goal_id]['data'][$weekIndex] += $val;
}

// running total (cumulative net) — tanpa cap target biar history kebaca
foreach ($goalSeries as $gId => $payload) {
    $arr = $payload['data'];

    for ($i = 1; $i < $weeksCount; $i++) {
        $arr[$i] += $arr[$i - 1];
    }

    $goalSeries[$gId]['data'] = $arr;
}

$goalSeries = array_filter($goalSeries, function ($p) {
    return !empty($p['label']); // ✅ buang label null / kosong
});

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

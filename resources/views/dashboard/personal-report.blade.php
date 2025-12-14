<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Poolin Report - Personal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="flex h-screen overflow-hidden bg-[#CFF1F9]">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
        
        <!-- LOGO -->
        <div class="text-3xl font-bold mb-0 flex items-center gap-2">
            <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" style="width: 100%; height: auto;">
        </div>

        <!-- NAV -->
        <nav class="space-y-2">

            <a href="{{ route('personal.home') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold 
                      {{ request()->routeIs('personal.home') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
                <img src="{{ asset('images/homePage.png') }}" alt="Home Page" style="width: 10%; height: auto;">
                <span>Home</span>
            </a>

            <a href="{{ route('personal.goals') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('personal.goals') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
                <img src="{{ asset('images/savings.png') }}" alt="Savings" style="width: 10%; height: auto;">
                <span>My Goals</span>
            </a>

            <a href="{{ route('personal.report') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('personal.report') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
                <img src="{{ asset('images/report.png') }}" alt="Report" style="width: 10%; height: auto;">
                <span>Report</span>
            </a>

            <a href="{{ route('personal.setting') }}"
          class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ request()->routeIs('personal.setting') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
        <img src="{{ asset('images/accountSetting.png') }}" alt="Setting" style="width: 10%; height: auto;"> 
        <span>Account Setting</span>
</a>
        </nav>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-[#03045E]"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-[#03045E]">Report</h1>
                    <p class="text-blue-800 -mt-0">Overview of your savings and goal progress</p>
                </div>
            </div>

            {{-- Personal / Group switch --}}
            <div class="flex items-center bg-white rounded-full p-1 shadow-md border border-[#03045E]">
                <button
                    class="px-4 py-1.5 rounded-full bg-[#03045E] text-white text-sm font-semibold">
                    Personal
                </button>
                <button
                    class="px-4 py-1.5 rounded-full text-[#03045E] text-sm font-semibold"
                    onclick="window.location.href='{{ route('group.home') }}'">
                    Group
                </button>
            </div>
        </div>

        {{-- BIG GRADIENT BOX --}}
        <div class="bg-gradient-to-b from-[#050691] to-[#0608C4] text-white rounded-2xl p-6">

            {{-- GRID: LEFT (FILTER + CHART) | RIGHT (CARDS) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT SIDE (span 2 columns) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- FILTER AREA --}}
                    <form method="GET"
                          action="{{ route('personal.report') }}"
                          class="flex flex-wrap gap-6">

                        {{-- Date Range --}}
                        <div>
                            <label class="text-sm">Date Range</label>
                            <div class="flex space-x-2 mt-1">
                                <select name="month"
                                        class="p-2 rounded-lg text-black mt-1">
                                    <option value="">All Months</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}"
                                            {{ (int)$month === $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endfor
                                </select>

                                <select name="year"
                                        class="p-2 rounded-lg text-black mt-1">
                                    <option value="">All Years</option>
                                    @for($y = now()->year-2; $y <= now()->year+1; $y++)
                                        <option value="{{ $y }}"
                                            {{ (int)$year === $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        {{-- All Goals --}}
                        <div>
                            <label class="text-sm">All Goals</label>
                            <div class="flex space-x-2 mt-1"></div>
                            <select name="goal_id"
                                    class="px-4 py-2 rounded-xl text-black border-gray-300 mt-1"
                                    id="goalFilter">
                                <option value="all" {{ $goalId === 'all' ? 'selected' : '' }}>All Goals</option>
                                @foreach($goals as $g)
                                    <option value="{{ $g->id }}"
                                            {{ (string)$goalId === (string)$g->id ? 'selected' : '' }}>
                                        {{ $g->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-white text-[#03045E] font-semibold text-sm hover:bg-blue-100 transition">
                                Apply
                            </button>
                        </div>
                    </form>

                    {{-- SAVING CHART --}}
                    <div class="bg-[#02153F] rounded-xl p-6 shadow">
                        <h3 class="text-center text-lg font-semibold mb-4 text-white">Saving Chart</h3>

                        <div class="bg-white/10 p-4 rounded-xl">
                            <canvas id="savingChart" class="w-full h-64"></canvas>
                        </div>
                    </div>

                </div>

                {{-- RIGHT SIDE CARDS --}}
                <div class="space-y-6">

                    {{-- Total Savings Added --}}
                    <div class="bg-[#CDE6FF] text-[#001233] rounded-2xl p-7 shadow flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-piggy-bank text-2xl text-[#023E8A]"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Total Savings Added</p>
                            <p class="text-2xl font-bold">
                                Rp {{ number_format($totalSavings, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-slate-600 mt-1">
                                From selected range
                            </p>
                        </div>
                    </div>

                    {{-- Finished Goals --}}
                    <div class="bg-[#CDE6FF] text-[#001233] rounded-2xl p-7 shadow flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-bullseye text-2xl text-[#023E8A]"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Total Finished Goals</p>
                            <p class="text-3xl font-bold">
                                {{ $totalFinishedGoals }}
                            </p>
                            <p class="text-xs text-slate-600 mt-1">
                                All time
                            </p>
                        </div>
                    </div>

                    {{-- Expenditure --}}
                    <div class="bg-[#CDE6FF] text-[#001233] rounded-2xl p-7 shadow flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-transfer text-2xl text-[#023E8A]"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Total Expenditure</p>
                            <p class="text-xl font-bold">
                                Rp {{ number_format($totalExpenditure, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-slate-600 mt-1">
                                Withdrawals in selected range
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            {{-- FULL-WIDTH TABLE --}}
            <div class="mt-8">
                <div class="bg-[#E2F4FF] rounded-2xl shadow overflow-hidden w-full">
                    <table class="w-full table-auto text-center text-[#001233]">
                        <thead class="bg-[#CDE6FF]">
                        <tr class="border-b border-[#9bbcd1]">
                            <th class="py-3 font-semibold text-sm">Date</th>
                            <th class="py-3 font-semibold text-sm">Goal</th>
                            <th class="py-3 font-semibold text-sm">Transaction</th>
                            <th class="py-3 font-semibold text-sm">Amount</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($transactions as $tx)
                            @php
                                $isSaving = $tx->jenis === 'saving';
                                $tabungan = $tx->tabungan;
                            @endphp
                            <tr class="border-b border-[#bcd8ea]">
                                <td class="py-3 text-sm">
                                    {{ \Carbon\Carbon::parse($tx->tgl_transaksi)->format('d/m/Y') }}
                                </td>
                                <td class="py-3 text-sm">
                                    {{ $tabungan?->nama ?? '-' }}
                                </td>
                                <td class="py-3 text-sm">
                                    {{ ucfirst($tx->jenis) }}
                                </td>
                                <td class="py-3 font-semibold text-sm {{ $isSaving ? 'text-green-700' : 'text-red-600' }}">
                                    {{ $isSaving ? '+ ' : '- ' }}
                                    Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-sm text-slate-500">
                                    No transactions for this filter.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

   {{-- ================== CHART (Weekly per Goal) ================== --}}
@php
    use Carbon\Carbon;

    // week labels fixed
    $weekLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];

    // bikin data weekly per goal dari $transactions (yang udah kamu punya di table)
    $weeklyData = []; // ['Goal A' => [0,0,0,0], 'Goal B' => [0,0,0,0]]

    foreach ($transactions as $tx) {
        // cuma saving yang masuk chart (kalau mau withdraw jadi negatif bilang ya)
        if ($tx->jenis !== 'saving') continue;

        $goalName = $tx->tabungan?->nama ?? 'Unknown';

        $date = Carbon::parse($tx->tgl_transaksi);
        $week = (int) ceil($date->day / 7); // 1-4
        $weekIndex = max(1, min(4, $week)) - 1;

        if (!isset($weeklyData[$goalName])) {
            $weeklyData[$goalName] = [0, 0, 0, 0];
        }

        $weeklyData[$goalName][$weekIndex] += (int) $tx->nominal;
    }

    // ubah jadi akumulatif biar kurvanya naik (Week2 += Week1 dst)
    foreach ($weeklyData as $goal => $weeks) {
        for ($i = 1; $i < 4; $i++) {
            $weeks[$i] += $weeks[$i - 1];
        }
        $weeklyData[$goal] = $weeks;
    }
@endphp

<script>
    const weekLabels = @json($weekLabels);
    const weeklyData = @json($weeklyData);

    const ctx = document.getElementById('savingChart');
    let savingChart = null;

    function rupiahFormat(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function renderWeeklyGoalChart() {
        if (!ctx) return;

        // kalau gak ada data, tetep bikin chart kosong biar gak blank
        const hasData = weeklyData && Object.keys(weeklyData).length > 0;

        const colors = [
            '#4DA3FF',
            '#8EC5FF',
            '#FFFFFF',
            '#FFD166',
            '#06D6A0',
            '#EF476F',
        ];

        const datasets = hasData
            ? Object.keys(weeklyData).map((goal, i) => ({
                label: goal,
                data: weeklyData[goal],
                borderWidth: 3,
                tension: 0.35,
                fill: false,
                borderColor: colors[i % colors.length],
                pointBackgroundColor: colors[i % colors.length],
            }))
            : [{
                label: 'No Data',
                data: [0, 0, 0, 0],
                borderWidth: 2,
                tension: 0.35,
                fill: false,
                borderColor: '#FFFFFF',
                pointBackgroundColor: '#FFFFFF',
            }];

        if (savingChart) savingChart.destroy();

        savingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weekLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: { color: 'white' }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${rupiahFormat(context.parsed.y)}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'white' },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white',
                            callback: (value) => rupiahFormat(value)
                        },
                        grid: { color: 'rgba(255,255,255,0.2)' }
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', renderWeeklyGoalChart);
</script>


   <script>
  const weeklyWeekLabels = @json($weeklyWeekLabels);
  const weeklyGoalData   = @json($weeklyGoalData);

  const datasets = weeklyGoalData.map((g) => ({
    label: g.label,
    data: g.data,
    borderWidth: 3,
    tension: 0.3,
    fill: false,
  }));

  new Chart(document.getElementById('savingChart'), {
    type: 'line',
    data: { labels: weeklyWeekLabels, datasets },
    options: {
      plugins: {
        legend: { labels: { color: 'white' } }
      },
      scales: {
        x: { ticks: { color: 'white' } },
        y: {
          ticks: {
            color: 'white',
            callback: (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
          }
        }
      }
    }
  });
</script>

</body>
</html>

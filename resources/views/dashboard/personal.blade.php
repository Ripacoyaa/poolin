<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Personal Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background-color: #CFF1F9; }
    </style>
</head>

<body class="flex h-screen overflow-hidden">

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

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            
            <div>
                <h1 class="text-2xl font-bold text-blue-900 flex items-center gap-2">
                    <img src="{{ asset('images/homeGroup.png') }}" alt="Home" style="width: 6.5%; height: auto;">
                    <span>Home</span>
                </h1>

                <p class="text-blue-800 ml-12 font-semibold -mt-1">
                    Hi {{ auth()->user()->name }}!
                </p>
            </div>

            <!-- PERSONAL / GROUP SWITCHER -->
            <div class="flex items-center bg-white rounded-full p-1 shadow-md border border-[#03045E]">

                <button class="px-4 py-1.5 rounded-full bg-[#03045E] text-white font-semibold text-sm">
                    Personal
                </button>

                <button onclick="window.location.href='{{ route('group.home') }}'"
                        class="px-4 py-1.5 rounded-full text-[#03045E] font-semibold text-sm">
                    Group
                </button>

            </div>
        </div>

        <!-- TOP CARDS -->
        <div class="grid grid-cols-3 gap-6 mb-6">

            {{-- CARD SAVING STREAK --}}
            <div class="bg-white rounded-2xl p-5 shadow-md">
                <p class="text-gray-600 font-semibold text-lg">Saving Streak</p>
                <div class="flex items-center gap-3 mt-4">
                    <span class="text-4xl">🔥</span>
                    <div>
                        <p class="text-3xl font-bold text-blue-900">
                            {{ $savingStreak }}
                        </p>
                        <p class="text-sm text-gray-600">times saving</p>
                    </div>
                </div>
            </div>

            {{-- CARD GOAL HIGHLIGHT --}}
            <div class="bg-white rounded-2xl p-5 shadow-md">
                <p class="text-gray-600 font-semibold text-lg">Goal Highlight</p>

                @if($goalHighlight)
                    <p class="mt-3 text-blue-900 font-semibold">
                        {{ $goalHighlight->nama }}
                    <p class="text-sm text-gray-600">
    Highest goal progress – {{ min(100, $goalHighlight->progress) }}%
</p>

                @else
                    <p class="mt-3 text-gray-500 text-sm">
                        No active goals yet.
                    </p>
                @endif
            </div>

            {{-- CARD NEAREST GOAL --}}
            <div class="bg-white rounded-2xl p-5 shadow-md">
                <p class="text-gray-600 font-semibold text-lg">Nearest Goal</p>

                @if($nearestGoal)
                    <p class="mt-3 text-blue-900 font-semibold">
                        {{ $nearestGoal->nama }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($nearestGoal->target_tanggal)->format('d/m/Y') }}
                    </p>
                @else
                    <p class="mt-3 text-gray-500 text-sm">
                        There is no goal with a target date yet.
                    </p>
                @endif
            </div>

        </div> {{-- END TOP CARDS GRID --}}

        <!-- MAIN SECTION -->
        <div class="grid grid-cols-3 gap-6">

            <!-- CHART PANEL -->
            <div class="col-span-2 bg-white p-8 rounded-xl shadow-xl border border-blue-800">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-blue-900 font-bold text-lg">Savings Progress</h2>
                    <span class="text-blue-900 font-semibold bg-blue-100 px-3 py-1 rounded-lg">
                        {{ now()->year }}
                    </span>
                </div>
                <canvas id="savingChart" height="80"></canvas>
            </div>

            {{-- CARD NEW ACTIVITY --}}
            <div class="bg-white rounded-2xl p-5 shadow-md">
                <p class="text-gray-600 font-semibold text-lg mb-3">New Activity</p>

                @forelse($newActivities as $tx)
                    <div class="text-sm text-gray-700 mb-2">
                        {{ $tx->jenis === 'saving' ? 'Menabung' : 'Menarik' }}
                        Rp{{ number_format($tx->nominal, 0, ',', '.') }}
                        ke "{{ optional($tx->tabungan)->nama ?? '-' }}"
                        <span class="text-gray-500">
                           – {{ $tx->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No activity yet.</p>
                @endforelse
            </div>

        </div> {{-- END MAIN SECTION GRID --}}

        <p class="text-center text-blue-900 mt-6 font-semibold text-sm">
            “Manage Your Finances Easily with Real-Time Savings Reports.”
        </p>

    </main>

    <!-- CHART SCRIPT -->
    <script>
        const ctx = document.getElementById('savingChart');

        const monthLabels = @json($chartLabels);   // contoh: ["Jan","Feb",...]
        const savingData  = @json($chartData);     // contoh: [0, 100000, 0, ...]

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Savings',
                    data: savingData,
                    borderWidth: 3,
                    borderColor: '#03045E',
                    backgroundColor: 'rgba(3,4,94,0.15)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                // format rupiah kasar
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>

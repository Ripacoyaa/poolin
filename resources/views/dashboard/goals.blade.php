<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Poolin - My Goals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="flex h-screen overflow-hidden bg-[#CFF1F9]">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
        <div class="text-3xl font-bold mb-0 flex items-center gap-2">
            <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" style="width: 100%; height: auto;">
        </div>

        <nav class="space-y-2 mt-6">

            <a href="{{ route('personal.home') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold
               {{ request()->routeIs('personal.home') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
                <img src="{{ asset('images/homePage.png') }}" alt="Home Page" style="width: 10%; height: auto;">
                <span>Home</span>
            </a>

            <a href="{{ route('personal.goals') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('personal.goals*') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
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

        <!-- HEADER (judul kiri, tombol kanan) -->
        <div class="max-w-[1150px] mx-auto flex items-start justify-between gap-6 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-blue-900 flex items-center gap-3">
                    <img src="{{ asset('images/money-bag.png') }}" alt="My Goals" class="w-8 h-8">
                    <span>My Goals</span>
                </h1>
                <p class="text-blue-800 ml-11 font-semibold -mt-1">
                    Manage all your saving goals
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap justify-end">
                <div class="flex items-center bg-white rounded-full p-1 shadow-md border border-[#03045E]">
                    <button class="px-4 py-1.5 rounded-full bg-[#03045E] text-white text-sm font-semibold">
                        Personal
                    </button>
                    <button onclick="window.location.href='{{ route('group.home') }}'"
                            class="px-4 py-1.5 rounded-full text-[#03045E] text-sm font-semibold">
                        Group
                    </button>
                </div>

                <button
                    class="px-5 py-2 bg-[#0608C4] hover:bg-[#050691] transition text-white rounded-xl font-semibold shadow"
                    onclick="window.location.href='{{ route('personal.goals.create') }}'">
                    + Create a New Goal
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-full border border-[#03045E] text-[#03045E] text-sm font-semibold bg-white hover:bg-blue-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="max-w-[1150px] mx-auto mb-4 text-sm text-green-700 bg-green-50 border border-green-200 px-4 py-2 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABS -->
        <div class="max-w-[1150px] mx-auto flex items-center justify-between mb-6">
            <div class="flex bg-white rounded-xl border border-blue-300 shadow overflow-hidden">
                <a href="{{ route('personal.goals', ['status' => 'active']) }}"
                   class="px-5 py-2 text-sm font-bold
                   {{ $statusFilter === 'active' ? 'bg-blue-100 text-blue-900' : 'text-blue-700 hover:bg-blue-50' }}">
                    Active
                </a>
                <a href="{{ route('personal.goals', ['status' => 'finished']) }}"
                   class="px-5 py-2 text-sm font-bold
                   {{ $statusFilter === 'finished' ? 'bg-blue-100 text-blue-900' : 'text-blue-700 hover:bg-blue-50' }}">
                    Finished
                </a>
            </div>
        </div>

        <!-- LIST GOALS -->
        <div class="max-w-[1150px] mx-auto space-y-6 pb-10">

            @forelse($goals as $goal)
                @php
                    $target     = (float) ($goal->target_tabungan ?? 0);
                    $collected  = (float) ($goal->total_terkumpul ?? 0);
                    $progress   = $target > 0 ? min(100, round(($collected / $target) * 100)) : 0;
                    $moneyLeft  = max(0, $target - $collected);
                @endphp

                <div class="bg-white rounded-2xl p-6 shadow-md border border-blue-100">
                    <div class="flex gap-6 items-start">

                        <!-- THUMB -->
                        <div class="shrink-0">
                            @if($goal->foto)
                                <img src="{{ asset('storage/' . $goal->foto) }}"
                                     class="w-24 h-24 rounded-xl object-cover border">
                            @else
                                <div class="w-24 h-24 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-semibold border">
                                    {{ $goal->nama ?? 'My Goal' }}
                                </div>
                            @endif
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-1">
                            <!-- TITLE + ACTIONS -->
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-bold text-[#03045E]">
                                        {{ $goal->nama ?? 'My Goal' }}
                                    </h2>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Status: <span class="font-semibold capitalize">{{ $goal->status ?? 'active' }}</span>
                                    </p>

                                    {{-- tampilkan target date sebagai teks (bukan input) --}}
                                    <p class="text-sm text-gray-500 mt-1">
                                        Target Date:
                                        <span class="font-semibold text-gray-700">
                                            {{ $goal->target_tanggal ? \Carbon\Carbon::parse($goal->target_tanggal)->format('d/m/Y') : '-' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="flex gap-3 text-[#03045E] mt-1">
                                    <a href="{{ route('personal.goals.edit', $goal) }}" class="text-lg">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('personal.goals.destroy', $goal) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus goal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-lg">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- SUMMARY -->
                            <p class="text-gray-600 text-sm mt-3">
                                Target: Rp {{ number_format($target, 0, ',', '.') }} ·
                                Collected: Rp {{ number_format($collected, 0, ',', '.') }} ·
                                Money left: Rp {{ number_format($moneyLeft, 0, ',', '.') }}
                            </p>

                            <!-- PROGRESS -->
                            <div class="mt-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-semibold text-gray-700">Progress</span>
                                    <span class="font-bold text-[#03045E]">{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                    <div class="h-full rounded-full"
                                         style="width: {{ $progress }}%; background: linear-gradient(90deg,#0077B6,#023E8A,#03045E);">
                                    </div>
                                </div>
                            </div>

                            <!-- STATS -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4 text-white text-sm">
                                <div class="bg-gradient-to-br from-[#023E8A] to-[#0077B6] p-3 rounded-xl">
                                    <p class="opacity-70">Collected</p>
                                    <p class="font-bold text-lg">Rp {{ number_format($collected, 0, ',', '.') }}</p>
                                </div>

                                <div class="bg-gradient-to-br from-[#023E8A] to-[#0096C7] p-3 rounded-xl">
                                    <p class="opacity-70">Money left</p>
                                    <p class="font-bold text-lg">Rp {{ number_format($moneyLeft, 0, ',', '.') }}</p>
                                </div>

                                <div class="bg-gradient-to-br from-[#023E8A] to-[#48CAE4] p-3 rounded-xl">
                                    <p class="opacity-70">Target</p>
                                    <p class="font-bold text-lg">Rp {{ number_format($target, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- CTA -->
                            @if(($goal->status ?? 'active') !== 'finished')
                            <button
                                class="w-full mt-5 bg-gradient-to-r from-[#023E8A] to-[#03045E] text-white py-2 text-base rounded-xl font-bold"
                                onclick="window.location.href='{{ route('personal.goals.save', $goal) }}'">
                                Save Now
                            </button>
                        @endif

                        </div>

                    </div>
                </div>

            @empty
                <p class="text-center text-gray-500 text-sm mt-8">
                    Belum ada goal pada kategori ini. Yuk buat satu dengan klik
                    <span class="font-semibold">"Create a New Goal"</span> 😊
                </p>
            @endforelse

        </div>

    </main>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Contribution</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { background-color:#CFF1F9; } </style>
</head>

<body class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
    <div class="text-3xl font-bold mb-0 flex items-center gap-2">
        <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" class="w-30 opacity90" />
    </div>

    <nav class="space-y-2 mt-6">
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]"
           href="{{ route('group.home') }}">
            <img src="{{ asset('images/homePage.png') }}" class="w-8 h-8 opacity90" />
            <span>Home</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]"
           href="{{ route('group.rooms') }}">
            <img src="{{ asset('images/meeting.png') }}" class="w-8 h-8 opacity90" />
            <span>My Rooms</span>
        </a>

        <div class="flex items-center gap-3 bg-[#023E8A] px-4 py-3 rounded-xl font-bold shadow-[0_4px_12px_rgba(0,0,0,0.25)]">
            <img src="{{ asset('images/donation.png') }}" class="w-8 h-8 opacity90" />
            <span>Contribution</span>
        </div>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]"
           href="{{ route('group.setting') }}">
            <img src="{{ asset('images/accountSetting.png') }}" class="w-8 h-8 opacity90" />
            <span>Account Setting</span>
        </a>
    </nav>
</aside>

<!-- MAIN -->
<main class="flex-1 p-8 overflow-y-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/donationLogo.png') }}" class="w-16 h-16 opacity-90" />
            <div>
                <h1 class="text-2xl font-bold text-blue-900 leading-tight">Contribution</h1>
                <p class="text-blue-800 font-semibold text-sm">See all your contributions in the rooms you join.</p>
            </div>
        </div>

        <div class="flex items-center bg-white rounded-full p-1 shadow-md border border-[#03045E]">
            <button onclick="window.location.href='{{ route('personal.home') }}'"
                    class="px-4 py-1.5 rounded-full text-[#03045E] font-semibold text-sm hover:bg-blue-100">
                Personal
            </button>
            <button class="px-4 py-1.5 rounded-full bg-[#03045E] text-white font-semibold text-sm">
                Group
            </button>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg px-4 py-2">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg px-4 py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-600 font-semibold">Total Contribution</p>
            <p class="text-3xl font-bold text-blue-700">
                Rp {{ number_format($totalContribution ?? 0, 0, ',', '.') }}
            </p>
            <p class="text-gray-500 text-sm mt-1">From all rooms</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-600 font-semibold">Total Withdraw</p>
            <p class="text-3xl font-bold text-orange-600">
                Rp {{ number_format($totalWithdraw ?? 0, 0, ',', '.') }}
            </p>
            <p class="text-gray-500 text-sm mt-1">Money taken out</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-gray-600 font-semibold">Active Rooms</p>
            <p class="text-3xl font-bold text-blue-600">{{ $activeRooms ?? 0 }}</p>
            <p class="text-gray-500 text-sm mt-1">Currently joined</p>
        </div>
    </div>

    <!-- SEARCH -->
    <div class="mb-6 relative w-1/2">
        <span class="absolute left-4 top-3 text-gray-400">🔍</span>
        <input id="searchInput" type="text" placeholder="Find a room"
               class="w-full pl-12 p-3 rounded-xl bg-[#E9F7FF] border border-transparent focus:border-blue-300 outline-none shadow-sm"
               oninput="searchRooms()">
    </div>

    <p id="noResult" class="text-center text-gray-500 mt-5 hidden">No result found</p>

    <!-- LIST -->
<div id="roomList" class="space-y-5">
    @forelse(($rooms ?? collect()) as $room)
        @php
            $tabungan = $room->tabungan;

            $target  = (int) ($tabungan->target_tabungan ?? 0);
            $total   = (int) ($tabungan->total_terkumpul ?? 0);
            $percent = ($target > 0) ? min(100, (int) round(($total / $target) * 100)) : 0;

            $members = (int) ($room->users_count ?? 0);

            $stat = $roomStats[$room->id] ?? [];
            $myContribution = (int) ($stat['contribution'] ?? 0);
            $myBalance      = (int) ($stat['balance'] ?? 0);
        @endphp

        <div class="roomCard bg-white rounded-2xl shadow p-6"
             data-name="{{ strtolower($room->nama_room ?? '') }}">

            <!-- HEADER ROOM -->
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">
                        {{ $room->nama_room ?? 'Untitled Room' }}
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Monthly • {{ $members }} members
                    </p>
                </div>

                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">
                    Active
                </span>
            </div>

            <!-- PROGRESS -->
            <div class="mt-4 w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                <div class="h-2 rounded-full {{ $percent >= 100 ? 'bg-green-500' : 'bg-blue-600' }}"
                     style="width: {{ $percent }}%"></div>
            </div>

            <!-- TARGET / TOTAL -->
            <div class="mt-2 text-sm text-gray-600">
                @if($target > 0)
                    Rp {{ number_format($total, 0, ',', '.') }}
                    <span class="text-gray-400">/ Rp {{ number_format($target, 0, ',', '.') }}</span>
                @else
                    <span class="text-gray-400">Target belum ditentukan</span>
                @endif
            </div>

            <!-- STATS -->
            <div class="flex justify-between mt-5">
                <div>
                    <p class="text-gray-500 text-sm">Total Contribution</p>
                    <p class="font-semibold text-gray-900">
                        Rp {{ number_format($myContribution, 0, ',', '.') }}
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-gray-500 text-sm">Saved Amount</p>
                    <p class="font-semibold text-green-600">
                        Rp {{ number_format($myBalance, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex gap-4 mt-6">
                <a href="{{ route('group.transaction', ['room' => $room->id, 'type' => 'saving']) }}"
                   class="flex-1 bg-green-500 text-center text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition">
                    Saving Money
                </a>

                <a href="{{ route('group.transaction', ['room' => $room->id, 'type' => 'withdraw']) }}"
                   class="flex-1 bg-[#03045E] text-center text-white py-3 rounded-xl font-semibold hover:bg-[#4b2ee0] transition">
                    Withdraw
                </a>
            </div>

        </div>
    @empty
        <p class="text-center text-gray-500 mt-6">No rooms found.</p>
    @endforelse
</div>


</main>

<script>
function searchRooms() {
    const input = (document.getElementById("searchInput").value || "").toLowerCase();
    const cards = document.querySelectorAll(".roomCard");
    let hasResult = false;

    cards.forEach(card => {
        const name = (card.getAttribute("data-name") || "").toLowerCase();
        if (name.includes(input)) {
            card.classList.remove("hidden");
            hasResult = true;
        } else {
            card.classList.add("hidden");
        }
    });

    document.getElementById("noResult").classList.toggle("hidden", hasResult);
}
</script>

</body>
</html>

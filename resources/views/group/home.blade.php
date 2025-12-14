<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Group Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
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
            <a href="{{ route('group.home') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold
                      {{ request()->routeIs('group.home') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
                <img src="{{ asset('images/homePage.png') }}" alt="Home Page" style="width: 10%; height: auto;">
                <span>Home</span>
            </a>

            <a href="{{ route('group.rooms') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('group.rooms') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
                <img src="{{ asset('images/meeting.png') }}" alt="My Room" style="width: 10%; height: auto;">
                <span>My Room</span>
            </a>

            <a href="{{ route('group.contributions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('group.contributions') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
                <img src="{{ asset('images/donation.png') }}" alt="Contribution" style="width: 10%; height: auto;">
                <span>Contribution</span>
            </a>

            <a href="{{ route('group.setting') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('group.setting') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
                <img src="{{ asset('images/accountSetting.png') }}" alt="Setting" style="width: 10%; height: auto;">
                <span>Account Setting</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <!-- LEFT: HOME TITLE -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/homeGroup.png') }}" class="w-10 h-10">
                <div>
                    <h1 class="text-2xl font-bold text-[#03045E]">Home</h1>
                    <p class="text-sm text-[#03045E] opacity-70">Group Mode</p>
                </div>
            </div>

            <!-- RIGHT: SWITCH PERSONAL / GROUP -->
            <div id="toggleSwitch" class="flex items-center bg-white border border-[#03045E] rounded-full p-1 shadow-md">
                <a href="{{ route('personal.home') }}"
                   class="px-4 py-1.5 rounded-full text-sm font-semibold
                          {{ request()->routeIs('personal.home') ? 'bg-[#03045E] text-white' : 'text-[#03045E]' }}">
                    Personal
                </a>

                <a href="{{ route('group.home') }}"
                   class="px-4 py-1.5 rounded-full text-sm font-semibold
                          {{ request()->routeIs('group.home') ? 'bg-[#03045E] text-white' : 'text-[#03045E]' }}">
                    Group
                </a>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <!-- TOTAL ROOMS -->
            <div class="bg-gradient-to-b from-[#050691] to-[#0608C4] text-white rounded-xl p-5 flex items-center gap-4 shadow-xl">
                <div class="w-14 h-14 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/community.png') }}" class="w-14 opacity-90">
                </div>
                <div>
                    <p class="opacity-80 text-sm">Total Rooms</p>
                    <p class="text-3xl font-bold leading-tight">{{ $totalRooms }}</p>
                </div>
            </div>

            <!-- ACTIVE ROOMS -->
            <div class="bg-gradient-to-b from-[#050691] to-[#0608C4] text-white rounded-xl p-5 flex items-center gap-4 shadow-xl">
                <div class="w-14 h-14 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/time-management.png') }}" class="w-14 opacity-90">
                </div>
                <div>
                    <p class="opacity-80 text-sm">Active Rooms</p>
                    <p class="text-3xl font-bold leading-tight">{{ $activeRooms }}</p>
                </div>
            </div>

            <!-- CONTRIBUTION -->
            <div class="bg-gradient-to-b from-[#050691] to-[#0608C4] text-white rounded-xl p-5 flex items-center gap-4 shadow">
                <div class="w-14 h-14 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/donation.png') }}" class="w-14 opacity-90">
                </div>
                <div>
                    <p class="opacity-80 text-sm">Contribution</p>
                    <p class="text-3xl font-bold leading-tight">
                        Rp {{ number_format($contributionThisMonth, 0, ',', '.') }}
                    </p>
                    <p class="text-xs opacity-70">This Month</p>
                </div>
            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="rounded-xl p-4 mb-0 bg-white/60 shadow-sm">
            <h3 class="font-bold text-lg text-[#03045E] mb-3">Quick Actions</h3>

            <div class="flex flex-wrap gap-4">
                <!-- Deposit Button (Join Room) -->
                <button onclick="openJoinRoom()"
                        class="flex items-center gap-2 px-4 py-2 bg-[#CFF1F9] rounded-lg
                               border-2 border-[#023E8A] text-[#023E8A] font-semibold
                               shadow-md hover:bg-[#b8e7f7] transition">
                    <img src="{{ asset('images/arrow.png') }}" class="w-6 h-6 opacity-90">
                    <span>Join room</span>
                </button>

                <!-- Create Room Button -->
                <button onclick="openCreateRoom()"
                        class="flex items-center gap-2 px-4 py-2 bg-[#CFF1F9] rounded-lg
                               border-2 border-[#023E8A] text-[#023E8A] font-semibold
                               shadow-md hover:bg-[#b8e7f7] transition">
                    <img src="{{ asset('images/add.png') }}" class="w-6 h-6 opacity-90">
                    <span>Create a new room</span>
                </button>
            </div>
        </div>

        <!-- JOIN ROOM MODAL -->
        <div id="joinRoomModal" class="fixed inset-0 bg-black/40 hidden z-50 flex justify-center items-center">
            <div class="bg-white w-96 p-6 rounded-2xl items-center shadow-xl">
                <h2 class="text-xl font-bold mb-3 text-blue-900">Join a Room</h2>

                <label class="text-sm text-gray-600">Enter Room Code</label>
                <input id="joinCode" type="text"
                       class="w-full mt-1 p-2 border rounded-lg bg-gray-100 focus:bg-white outline-none">

                <div class="flex justify-end gap-3 mt-6">
                    <button onclick="closeJoinRoom()"
                            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                        Cancel
                    </button>

                    <button onclick="submitJoinRoom()"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Join
                    </button>
                </div>
            </div>
        </div>

        <!-- CREATE ROOM MODAL -->
        <div id="createRoomModal" class="fixed inset-0 bg-black/40 hidden z-50 flex justify-center items-center">
            <div class="bg-white w-[420px] p-6 rounded-2xl shadow-xl">
                <h2 class="text-xl font-bold mb-4 text-blue-900">Create a New Room</h2>

                <form method="POST" action="{{ route('group.create.store') }}">
                    @csrf

                    <label class="text-sm text-gray-600">Group Name</label>
                    <input name="nama_room" required
                           class="w-full mt-1 p-2 border rounded-lg bg-gray-100 mb-3">

                    <label class="text-sm text-gray-600">Target Amount</label>
                    <input name="target_tabungan" type="number" required
                           class="w-full mt-1 p-2 border rounded-lg bg-gray-100 mb-3">

                    <label class="text-sm text-gray-600">Target Date</label>
                    <input name="target_tanggal" type="date" required
                           class="w-full mt-1 p-2 border rounded-lg bg-gray-100 mb-3">

                    <label class="text-sm text-gray-600">Created Date</label>
                    <input id="createdDate" type="text" value="{{ now()->format('Y-m-d') }}" disabled
                           class="w-full mt-1 p-2 border rounded-lg bg-gray-200 mb-4">

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeCreateRoom()"
                                class="px-4 py-2 rounded-lg bg-gray-200">
                            Cancel
                        </button>

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-green-600 text-white">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Popup Success Create Room -->
        <div id="successPopup" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-2xl p-8 w-[420px] text-center shadow-xl">

                <h2 class="text-2xl font-semibold text-[#0D3B66]">
                    Room successfully created
                </h2>

                <p class="text-gray-500 mt-2">
                    Share this code with your friends so they can join
                </p>

                <div class="mt-5">
                    <input id="generatedCode"
                           type="text"
                           class="w-full text-center text-2xl font-bold border rounded-xl py-3 bg-gray-100"
                           readonly />
                </div>

                @if(session('created_room_code'))
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            document.getElementById("generatedCode").value = "{{ session('created_room_code') }}";
                            document.getElementById("successPopup").classList.remove("hidden");
                        });
                    </script>
                @endif

                <button onclick="copyRoomCode()"
                        class="mt-3 w-full py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm font-medium">
                    Copy Code
                </button>

                <button onclick="window.location.href='{{ route('group.rooms') }}'"
                        class="mt-5 w-full py-3 bg-[#0D3B66] hover:bg-[#0b3054] text-white rounded-xl font-semibold">
                    Enter the room
                </button>
            </div>
        </div>

        <!-- YOUR ROOMS -->
        <div class="bg-[#D5EDFF] rounded-xl p-4 mb-6 mt-6">
            <h3 class="font-bold text-lg text-[#03045E] mb-3">Your Rooms</h3>

            <div class="space-y-4">
               @foreach(($rooms ?? collect()) as $room)
@php
    $tabungan = $room->tabungan; // kalau relasi hasOne
    $target  = (int) ($tabungan->target_tabungan ?? 0);
    $total   = (int) ($tabungan->total_terkumpul ?? 0);
    $collected = (int) ($tabungan->total_terkumpul ?? 0);
    $percent = $target > 0 ? min(100, (int) round(($total / $target) * 100)) : 0;
@endphp

                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-lg font-bold text-[#03045E]">{{ $room->nama_room }}</div>
                                <div class="text-sm text-gray-500">{{ $room->jenis_room ?? 'Group room' }}</div>
                            </div>
                            <div class="text-sm font-bold text-[#03045E]">{{ $percent }}%</div>
                        </div>

                        <div class="mt-3 w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="h-2 rounded-full bg-blue-600" style="width: {{ $percent }}%"></div>
                        </div>

                       <div class="mt-3 flex justify-between text-sm text-gray-600">
    <div>Rp {{ number_format($collected, 0, ',', '.') }}</div>
    <div>Target Rp {{ number_format($target, 0, ',', '.') }}</div>
</div>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('group.rooms.show', $room->id) }}"
                               class="text-blue-700 font-semibold hover:underline">
                                View detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TOP CONTRIBUTOR + RECENT ACTIVITY -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full mt-6">

    <!-- TOP CONTRIBUTOR -->
    <div class="bg-[#D5EDFF] rounded-2xl p-4">
        <h3 class="font-semibold text-lg text-[#03045E] mb-4">
            Top Contributor of the Month
        </h3>

        <div class="space-y-3">
            @forelse(($topContributors ?? collect()) as $i => $row)
                @php
                    $u = $row->user;
                    $icon = match($i) {
                        0 => asset('images/award.png'),
                        1 => asset('images/silver-medal.png'),
                        2 => asset('images/bronze.png'),
                        default => asset('images/award.png'),
                    };
                @endphp

                <div class="bg-white rounded-xl p-3 shadow flex items-center gap-3">
                    <img src="{{ $icon }}" class="w-10">

                    <div>
                        <p class="font-semibold text-[#03045E]">
                            {{ $u->name ?? 'User' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Rp{{ number_format((int)$row->total,0,',','.') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-3 shadow text-gray-500">
                    Belum ada kontribusi bulan ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-[#D5EDFF] rounded-2xl p-4">
        <h3 class="font-semibold text-lg text-[#03045E] mb-4">
            Recent Activity
        </h3>

        <div class="space-y-3">
            @forelse(($recentActivities ?? collect()) as $a)
                <div class="bg-white p-3 rounded-xl shadow flex justify-between items-center">
                    <p class="text-gray-800">
                        <span class="font-semibold">
                            {{ $a->user->name ?? 'User' }}
                        </span>
                        deposited ({{ $a->room->nama_room ?? '-' }})
                        <span class="text-gray-500 text-sm">
                            • {{ \Carbon\Carbon::parse($a->tgl_transaksi)->diffForHumans() }}
                        </span>
                    </p>

                    <p class="font-semibold text-[#03045E]">
                        Rp{{ number_format((int)$a->nominal,0,',','.') }}
                    </p>
                </div>
            @empty
                <div class="bg-white p-3 rounded-xl shadow text-gray-500">
                    Belum ada aktivitas terbaru.
                </div>
            @endforelse
        </div>
    </div>

</div>


    </main>

    <script>
        // ------------------------- JOIN ROOM -------------------------
        function openJoinRoom() {
            document.getElementById("joinRoomModal").classList.remove("hidden");
        }
        function closeJoinRoom() {
            document.getElementById("joinRoomModal").classList.add("hidden");
        }
        function submitJoinRoom() {
            const code = document.getElementById("joinCode").value.trim().toUpperCase();
            if (!code) {
                alert("Please enter a room code.");
                return;
            }
            alert("Joining room with code: " + code);
            closeJoinRoom();
        }

        // ------------------------- CREATE ROOM -------------------------
        function openCreateRoom() {
            document.getElementById("createRoomModal").classList.remove("hidden");
            const today = new Date().toISOString().split("T")[0];
            const el = document.getElementById("createdDate");
            if (el) el.value = today;
        }
        function closeCreateRoom() {
            document.getElementById("createRoomModal").classList.add("hidden");
        }

        // Copy
        function copyRoomCode() {
            const code = document.getElementById("generatedCode").value;
            navigator.clipboard.writeText(code);
            alert("Room code copied!");
        }
    </script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - {{ $room->nama_room }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #CFF1F9;
        }
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
                      {{ request()->routeIs('personal.home') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
                <img src="{{ asset('images/homePage.png') }}" alt="Home Page" style="width: 10%; height: auto;">
                <span>Home</span>
            </a>

            <a href="{{ route('group.rooms') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('personal.goals') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
                <img src="{{ asset('images/meeting.png') }}" alt="My Room" style="width: 10%; height: auto;">
                <span>My Room</span>
            </a>

            <a href="{{ route('group.contributions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                      {{ request()->routeIs('personal.report') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
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

 <!-- ========== MAIN CONTENT ========== -->
<main class="flex-1 p-8 overflow-y-auto">

    @php
        // angka-angka basic buat progress, aman kalau null
        $target    = $room->target_tabungan ?? 0;
        $collected = $room->total_terkumpul ?? 0;
        $progress  = $target > 0 ? min(100, round($collected / $target * 100)) : 0;

        $membersCount = $room->members_count
            ?? ($room->members?->count() ?? null);

        $status = strtolower($room->status ?? 'active');
        $isActive = !in_array($status, ['finished', 'completed']);
    @endphp

    <!-- Top Section -->
    <div class="mb-6">

        <!-- Back Button -->
        <button onclick="window.location.href='{{ route('group.rooms') }}'"
                class="inline-flex items-center gap-2 bg-[#023E8A] text-white px-4 py-2 rounded-xl font-semibold shadow hover:bg-[#0353A4] transition mb-4">
            Back to my Rooms
        </button>

        <!-- Title Section -->
        <div class="flex items-center gap-3">
    
            <div>
                <h1 class="text-3xl font-bold text-[#03045E]">
                    {{ $room->nama_room }}
                </h1>
                <p class="text-blue-800 -mt-1">
                    {{ $room->jenis_room ?? 'Group savings' }}
                    @if(!is_null($membersCount))
                        • {{ $membersCount }} members
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- ========== PROGRESS BOX ========== -->
@php
    $tabungan = $room->tabungan;

    $target    = (int) ($tabungan->target_tabungan ?? 0);
    $collected = (int) ($tabungan->total_terkumpul ?? 0);

    $progress = $target > 0
        ? min(100, round(($collected / $target) * 100))
        : 0;

    $rawStatus   = strtolower($tabungan->status ?? ($progress >= 100 ? 'completed' : 'active'));
    $isCompleted = in_array($rawStatus, ['finished','completed']);
    $isActive    = !$isCompleted;
@endphp

<div class="w-full bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
    <h2 class="text-xl font-bold text-[#03045E] mb-4">Progress</h2>

    <div class="flex justify-between items-center mb-2">
        <p class="text-gray-700">
            Created on
            <strong>
                {{ optional($room->created_at)->format('d M Y') }}
            </strong>
        </p>

        <span class="text-green-700 border border-green-500 px-3 py-1 rounded-lg text-sm font-semibold bg-green-50">
            ● {{ $isActive ? 'Active' : 'Completed' }}
        </span>
    </div>

    <p class="text-gray-700">
        Rp {{ number_format($collected, 0, ',', '.') }}
        collected from
        Rp {{ number_format($target, 0, ',', '.') }}
    </p>

    <!-- Progress Bar (samain kayak contributions/my rooms) -->
    <div class="mt-4 w-full bg-gray-200 rounded-full h-2 overflow-hidden">
        <div class="h-2 rounded-full bg-[#0077B6]"
             style="width: {{ $progress }}%"></div>
    </div>
</div>


    <!-- ========== SEARCH BAR ========== -->
    <div class="w-full flex justify-center mb-6">
        <input type="text"
               placeholder="Search member..."
               class="w-1/2 p-3 border border-gray-300 rounded-xl shadow-sm 
                      focus:ring-2 focus:ring-[#023E8A] outline-none">
    </div>

    <!-- ========== MEMBER LIST BOX ========== -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">

    {{-- ===== CARD 1: MEMBER LIST ===== --}}
<div class="bg-white rounded-2xl border border-gray-200 p-6">
    <h2 class="text-xl font-bold text-[#03045E] mb-4">Member List</h2>

    <div class="space-y-4">
        @forelse($room->users as $member)
            <div class="flex items-center gap-4 border rounded-2xl p-4">

                {{-- AVATAR --}}
               <div class="w-12 h-12 rounded-full overflow-hidden bg-blue-100 flex items-center justify-center">
    <img
        src="{{ $member->photo_url }}"
        alt="{{ $member->name }}"
        class="w-full h-full object-cover"
    />
</div>



                {{-- INFO --}}
                <div>
                    <p class="font-semibold text-gray-900">
                        {{ $member->name ?? 'User' }}
                    </p>
                    <p class="text-gray-500 text-sm">
                        {{ (int)$member->id === (int)$room->user_id ? 'tabungan' : 'Member' }}
                    </p>
                </div>

            </div>
        @empty
            <p class="text-gray-500">Belum ada member yang join.</p>
        @endforelse
    </div>
</div>

    {{-- ===== END CARD 1 ===== --}}

    {{-- JARAK ANTAR CARD --}}
    <div class="h-6"></div>

    {{-- ===== CARD 2: MEMBER CONTRIBUTION ===== --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-[#03045E] mb-4">Member Contribution</h2>

        {{-- isi contribution kamu di sini --}}
        {{-- contoh --}}
        @forelse($contributions as $c)
            <div class="py-4 border-b last:border-b-0">
                <strong>{{ $c->user->name }}</strong> deposits
                <strong>Rp{{ number_format($c->nominal,0,',','.') }}</strong>
                <span class="text-gray-500 text-sm">• {{ $c->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <p class="text-gray-500">Belum ada transaksi.</p>
        @endforelse
    </div>
    {{-- ===== END CARD 2 ===== --}}

</div>


</main>

<script>
// sementara masih dummy data JS, sama seperti HTML asli kamu
const members = [
    { name: "Andi", role: "tabungan" },
    { name: "Rian", role: "Member" },
    { name: "Bagas", role: "Member" },
    { name: "Sinta", role: "Member" },
    { name: "Dimas", role: "Member" },
    { name: "Rika", role: "Member" },
    { name: "Budi", role: "Member" },
    { name: "Nia", role: "Member" },
    { name: "Fajar", role: "Member" },
    { name: "Lilis", role: "Member" }
];

const pageSize = 5;
let currentPage = 0;

function generateMemberItem(member) {
    return `
        <div class="flex items-center justify-between p-3 rounded-xl border hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-200 text-blue-900 rounded-full flex items-center justify-center text-xl font-bold">
                    ${member.name.charAt(0)}
                </div>
                <div>
                    <p class="font-bold text-[#03045E]">${member.name}</p>
                    <p class="text-sm text-gray-600">${member.role}</p>
                </div>
            </div>
        </div>
    `;
}

function renderMemberList() {
    const container = document.getElementById("memberList");
    const start = currentPage * pageSize;
    const end = start + pageSize;

    const paginatedMembers = members.slice(start, end);
    container.innerHTML = paginatedMembers.map(m => generateMemberItem(m)).join("");

    document.getElementById("prevBtn").disabled = currentPage === 0;
    document.getElementById("nextBtn").disabled = end >= members.length;
}

document.getElementById("nextBtn").onclick = () => {
    currentPage++;
    renderMemberList();
};

document.getElementById("prevBtn").onclick = () => {
    currentPage--;
    renderMemberList();
};

renderMemberList();
</script>

</body>
</html>

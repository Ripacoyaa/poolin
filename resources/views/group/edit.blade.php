<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Edit Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background-color: #CFF1F9; }
    </style>
</head>

<body class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
    <div class="text-3xl font-bold mb-4 flex items-center gap-2">
        <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" style="width: 100%; height: auto;">
    </div>

    <nav class="space-y-2">
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.home') ? 'bg-[#023E8A] shadow' : 'hover:bg-[#023E8A] hover:shadow' }}"
           href="{{ route('group.home') }}">
            <img src="{{ asset('images/homePage.png') }}" class="w-8 h-8" />
            <span>Home</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.rooms*') ? 'bg-[#023E8A] shadow' : 'hover:bg-[#023E8A] hover:shadow' }}"
           href="{{ route('group.rooms') }}">
            <img src="{{ asset('images/meeting.png') }}" class="w-8 h-8" />
            <span>My Rooms</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.contributions') ? 'bg-[#023E8A] shadow' : 'hover:bg-[#023E8A] hover:shadow' }}"
           href="{{ route('group.contributions') }}">
            <img src="{{ asset('images/donation.png') }}" class="w-8 h-8" />
            <span>Contribution</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.setting') ? 'bg-[#023E8A] shadow' : 'hover:bg-[#023E8A] hover:shadow' }}"
           href="{{ route('group.setting') }}">
            <img src="{{ asset('images/accountSetting.png') }}" class="w-8 h-8" />
            <span>Account Setting</span>
        </a>
    </nav>
</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 p-10 overflow-y-auto">

    <!-- TITLE -->
    <h1 class="text-3xl font-bold text-[#022859]">Edit Room</h1>
    <p class="text-[#476E9E] mb-8">Update your room details below</p>

    {{-- error box --}}
    @if($errors->any())
        <div class="mb-6 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg px-3 py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- FORM (SATU, UTUH) -->
    <form method="POST" action="{{ route('group.rooms.update', $room->id) }}">
        @csrf
        @method('PUT')

        <!-- ROOM DETAILS SECTION -->
        <section class="bg-white shadow-md p-6 rounded-xl border border-[#BFDFFB]">
            <h2 class="text-xl font-bold text-[#012A4A] mb-4">Room Details</h2>

            <!-- ROOM NAME -->
            <label class="block font-semibold text-[#013A63] mb-1">Room Name</label>
            <input
                name="nama_room"
                class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-2 focus:ring-blue-400"
                type="text"
                placeholder="Office Lottery"
                value="{{ old('nama_room', $room->nama_room) }}">

            <!-- TARGET FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Target Amount -->
                <div>
                    <label class="block font-semibold text-[#013A63] mb-1">Target Amount</label>
                    <input
                        id="targetAmount"
                        name="target_tabungan"
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                        type="text"
                        placeholder="Rp 5.000.000"
                    value="{{ old('target_tabungan', $room->tabungan ? ('Rp '.number_format((int)$room->tabungan->target_tabungan, 0, ',', '.')) : '') }}">
                    <p class="text-xs text-gray-500 mt-1">Input angka, nanti auto-format Rp.</p>
                </div>

                <!-- Target Date -->
                <div>
                    <label class="block font-semibold text-[#013A63] mb-1">Target Date</label>
                    <input
                        name="target_tanggal"
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                        type="date"
                        value="{{ old('target_tanggal', isset($room->tabungan) ? $room->tabungan->target_tanggal : '') }}">
                </div>

            </div>

            <!-- MEMBERS SECTION -->
            <h2 class="text-xl font-bold text-[#012A4A] mt-8 mb-3">Members</h2>

            <div id="memberList" class="space-y-3">
                @php
                    // sesuaikan kalau relasinya beda
                    $members = $room->users ?? [];
                @endphp

                @if(count($members) === 0)
                    <div class="text-sm text-gray-500">No members found.</div>
                @else
                    @foreach($members as $m)
                        <div class="flex justify-between items-center bg-white border p-3 rounded-lg shadow-sm">
                            <span class="font-medium text-[#012A4A]">
                                {{ $m->name ?? $m->nama ?? 'Member' }}
                            </span>
                            <span class="text-xs text-gray-400">Member</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        <!-- BUTTON ACTIONS (DI DALAM FORM) -->
        <div class="flex justify-center gap-4 mt-8">
            <button type="submit"
                    class="bg-[#12248A] text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-[#0e1c6b]">
                Save Change
            </button>

            <a href="{{ route('group.rooms') }}"
               class="bg-white px-6 py-2 rounded-lg border font-semibold hover:bg-gray-100 inline-block text-center">
                Cancel
            </a>
        </div>
    </form>

</main>

<script>
    function formatRupiahValue(raw) {
        let angka = (raw || "").toString().replace(/[^0-9]/g, "");
        if (!angka) return "";
        return "Rp " + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const targetAmountInput = document.getElementById("targetAmount");
    if (targetAmountInput) {
        targetAmountInput.addEventListener("input", () => {
            targetAmountInput.value = formatRupiahValue(targetAmountInput.value);
        });
        // rapihin saat load
        targetAmountInput.value = formatRupiahValue(targetAmountInput.value);
    }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - My Rooms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>

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
    <nav class="space-y-2 mt-6">

        <a href="{{ route('group.home') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.home') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
            <img src="{{ asset('images/homePage.png') }}" class="w-8 h-8 opacity90" />
            <span>Home</span>
        </a>

        <a href="{{ route('group.rooms') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.rooms') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
            <img src="{{ asset('images/meeting.png') }}" class="w-8 h-8 opacity90" />
            <span>My Rooms</span>
        </a>

        <a href="{{ route('group.contributions') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.contributions') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
            <img src="{{ asset('images/donation.png') }}" class="w-8 h-8 opacity90" />
            <span>Contribution</span>
        </a>

        <a href="{{ route('group.setting') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                  {{ request()->routeIs('group.setting') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
            <img src="{{ asset('images/accountSetting.png') }}" class="w-8 h-8 opacity90" />
            <span>Account Setting</span>
        </a>

    </nav>
</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 p-8 overflow-y-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div class="flex items-center gap-2">
            <img src="{{ asset('images/community.png') }}" class="w-16 h-16 opacity-90" />
            <div>
                <h1 class="text-2xl font-bold text-blue-900 leading-tight">My Rooms</h1>
                <p class="text-blue-800 font-semibold text-sm">View and manage all your savings room.</p>
            </div>
        </div>

        <!-- PERSONAL/GROUP SWITCHER -->
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

    {{-- flash sukses / error --}}
    @if(session('success'))
        <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg px-3 py-2">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg px-3 py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- ROOMS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($rooms as $room)
           @php
    $tabungan = $room->tabungan;

    $target  = (int) ($tabungan->target_tabungan ?? 0);
    $total   = (int) ($tabungan->total_terkumpul ?? 0);

    $progress = $target > 0
        ? min(100, round(($total / $target) * 100))
        : 0;

    // jumlah member
    $members = (int) ($room->users_count ?? 0);

    // status completed / active (SAMA kayak contributions)
    $rawStatus   = strtolower($tabungan->status ?? ($progress >= 100 ? 'completed' : 'active'));
    $isCompleted = in_array($rawStatus, ['finished', 'completed']);

    // owner room
    $istabungan = auth()->id() === (int) ($room->user_id ?? 0);
@endphp

            <div class="bg-white rounded-2xl p-6 shadow-md border border-[#BFDFFB] relative">

                {{-- EDIT / DELETE (ONLY tabungan) --}}
                @if($istabungan)
                    <div class="absolute top-5 right-6 flex items-center gap-4 text-sm font-semibold">
                        <a href="{{ route('group.rooms.edit', $room->id) }}"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        {{-- delete pakai modal --}}
                        <button type="button"
                                class="text-red-600 hover:underline"
                                onclick="openDeleteModal('{{ route('group.rooms.destroy', $room->id) }}')">
                            Delete
                        </button>
                    </div>
                @endif

                <h2 class="text-2xl font-bold text-[#03045E]">
                    {{ $room->nama_room }}
                </h2>

                <p class="text-gray-600 text-sm mt-1">
                    Monthly – {{ $members }} members
                </p>

                {{-- STATUS --}}
                <div class="mt-3">
                    @if($isCompleted)
                        <span class="inline-block bg-green-500 text-white text-xs font-semibold px-4 py-1 rounded-full">
                            Completed
                        </span>
                    @else
                        <span class="inline-block bg-[#0077B6] text-white text-xs font-semibold px-4 py-1 rounded-full">
                            Active
                        </span>
                    @endif
                </div>

                {{-- PROGRESS BAR --}}
                <div class="w-full bg-gray-200 h-2 rounded-full mt-4 overflow-hidden">
    <div class="h-2 rounded-full bg-[#0077B6]"
         style="width: {{ $progress }}%"></div>
</div>


                {{-- NOMINAL --}}
               <p class="mt-2 text-[#012A4A] font-semibold">
    Rp {{ number_format($total, 0, ',', '.') }}
    <span class="text-gray-500 font-normal">
        of Rp {{ number_format($target, 0, ',', '.') }}
    </span>
</p>


                {{-- VIEW ROOM BUTTON --}}
                <button
                    onclick="window.location.href='{{ route('group.rooms.show', $room->id) }}'"
                    class="mt-5 w-full bg-[#023E8A] hover:bg-[#0353A4] text-white font-semibold py-3 rounded-xl">
                    View Room
                </button>
            </div>

        @empty
            <div class="col-span-1 md:col-span-2">
                <div class="bg-white rounded-2xl p-6 shadow-md border border-dashed border-[#9BBEE0] text-center">
                    <p class="text-sm text-[#012A4A]">
                        You don't have any group rooms yet.
                        <br>
                        Create a room from <span class="font-semibold">Group Home</span> or ask your friend for a room code 💙
                    </p>
                </div>
            </div>
        @endforelse
    </div>

</main>

<!-- MODAL DELETE (SINGLE) -->
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl shadow-xl w-80 text-center">
        <h2 class="text-xl font-bold text-[#03045E] mb-3">Delete Room?</h2>
        <p class="text-gray-600 mb-5 text-sm">This action cannot be undone.</p>

        <div class="flex gap-3">
            <button class="flex-1 bg-gray-300 py-2 rounded-lg hover:bg-gray-400"
                    onclick="closeDeleteModal()">
                Cancel
            </button>

            <form id="deleteForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteModal');
        const form  = document.getElementById('deleteForm');

        form.action = actionUrl;
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteForm').action = '';
    }

    // optional: klik area gelap untuk close
    document.getElementById('deleteModal').addEventListener('click', (e) => {
        if (e.target.id === 'deleteModal') closeDeleteModal();
    });
</script>

</body>
</html>

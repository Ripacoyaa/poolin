<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Transaction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { background-color:#CFF1F9; } </style>
</head>

<body class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
    <div class="text-3xl font-bold mb-0 flex items-center gap-2">
        <img src="{{ asset('images/logoPoolin.png') }}" class="w-30 opacity90" />
    </div>

    <nav class="space-y-2">
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-[#023E8A]"
           href="{{ route('group.home') }}">
            <img src="{{ asset('images/homePage.png') }}" class="w-8 h-8" />
            <span>Home</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-[#023E8A]"
           href="{{ route('group.rooms') }}">
            <img src="{{ asset('images/meeting.png') }}" class="w-8 h-8" />
            <span>My Rooms</span>
        </a>

        <div class="flex items-center gap-3 bg-[#023E8A] px-4 py-3 rounded-xl font-bold">
            <img src="{{ asset('images/donation.png') }}" class="w-8 h-8" />
            <span>Contribution</span>
        </div>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-[#023E8A]"
           href="{{ route('group.setting') }}">
            <img src="{{ asset('images/accountSetting.png') }}" class="w-8 h-8" />
            <span>Account Setting</span>
        </a>
    </nav>
</aside>

<!-- MAIN -->
<main class="flex-1 p-4 overflow-y-auto">
    @php
        $tabungan = $room->tabungan ?? null;
        $target = (int) ($tabungan->target_tabungan ?? 0);
        $total  = (int) ($tabungan->total_terkumpul ?? 0);
        $progress = ($target > 0) ? min(100, (int) round(($total / $target) * 100)) : 0;

        $isWithdraw = ($type ?? 'saving') === 'withdraw';
    @endphp

    <!-- GOAL HEADER -->
    <div class="flex items-center gap-5 bg-[#E4F1FF] p-4 rounded-xl border border-blue-200 shadow mb-6">
       
        <div>
            <h2 class="text-2xl font-bold text-[#03045E]">
                Save to : {{ $room->nama_room ?? '-' }}
            </h2>
            <p class="text-gray-700">Target : Rp {{ number_format($target, 0, ',', '.') }}</p>
            <p class="text-gray-700">Progress : {{ $progress }}%</p>
        </div>
    </div>
</div>
    @if($errors->any())
        <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg px-4 py-2">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    <!-- TRANSACTION BOX -->
    <div class="bg-white p-6 rounded-2xl shadow-xl border w-full">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-2xl font-bold text-[#03045E]">Transaction</h2>
            <div class="h-6 w-[2px] bg-[#03045E] opacity-40"></div>
            <h2 class="text-xl font-semibold text-[#03045E]">
                {{ $isWithdraw ? 'Withdraw' : 'Saving' }}
            </h2>
        </div>

        <!-- TABS -->
        <div class="flex mb-5 h-10">
            <a href="{{ route('group.transaction', $room->id) }}?type=saving"
               class="flex-1 text-center flex items-center justify-center font-semibold rounded-l-xl
                      {{ $isWithdraw ? 'bg-blue-100 text-[#03045E]' : 'bg-[#023E8A] text-white' }}">
                Saving
            </a>

            <a href="{{ route('group.transaction', $room->id) }}?type=withdraw"
               class="flex-1 text-center flex items-center justify-center font-semibold rounded-r-xl
                      {{ $isWithdraw ? 'bg-[#023E8A] text-white' : 'bg-blue-100 text-[#03045E]' }}">
                Withdraw
            </a>
        </div>

        <!-- FORM -->
        <form method="POST"
              action="{{ $isWithdraw ? route('group.contributions.withdraw', $room->id) : route('group.contributions.spend', $room->id) }}"
              enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="font-semibold text-gray-700">Date</label>
                    <input type="date" name="tanggal"
                           class="w-full border rounded-lg p-2 mt-1"
                           value="{{ old('tanggal', now()->toDateString()) }}"
                           required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Amount (Rp)</label>
                    <input id="amountInput" type="text" inputmode="numeric"
                           class="w-full border rounded-lg p-2 mt-1"
                           value="{{ old('nominal') }}"
                           oninput="formatRupiah(this)"
                           placeholder="Rp 50.000"
                           required>
                    <input type="hidden" name="nominal" id="nominalRaw" value="">
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Upload Photo</label>
                    <input type="file" name="bukti" accept="image/*"
                           class="w-full border rounded-lg p-2 bg-gray-50 mt-1"
                           required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Note</label>
                    <textarea name="keterangan"
                              class="w-full border rounded-lg p-2 mt-1 h-20"
                              placeholder="Optional note...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit"
                        class="w-1/2 py-2 bg-[#03045E] text-white text-center rounded-xl font-bold">
                    Save
                </button>

                <a href="{{ route('group.contributions') }}"
                   class="w-1/2 py-2 bg-gray-300 text-gray-800 text-center rounded-xl font-bold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</main>

<script>
function formatRupiah(input) {
    let value = (input.value || "").replace(/[^0-9]/g, "");
    if (value === "") {
        input.value = "";
        document.getElementById("nominalRaw").value = "";
        return;
    }
    input.value = "Rp " + new Intl.NumberFormat("id-ID").format(value);
    document.getElementById("nominalRaw").value = value;
}
</script>

</body>
</html>

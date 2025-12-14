<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Save Now - {{ $goal->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#CFF1F9] min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
        <div class="text-3xl font-bold mb-0 flex items-center gap-2">
            <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" style="width: 100%; height: auto;">
        </div>

        <nav class="space-y-2 mt-6">
            <a href="{{ route('personal.home') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-[#023E8A] transition">
                <img src="{{ asset('images/homePage.png') }}" alt="Home" style="width: 10%; height: auto;">
                Home
            </a>

            <a href="{{ route('personal.goals') }}"
               class="flex items-center gap-3 bg-[#023E8A] px-4 py-3 rounded-xl font-bold shadow-lg">
                <img src="{{ asset('images/savings.png') }}" alt="My Goals" style="width: 10%; height: auto;">
                My Goals
            </a>

            <a href="{{ route('personal.report') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-[#023E8A] transition">
                <img src="{{ asset('images/report.png') }}" alt="Report" style="width: 10%; height: auto;">
                Report
            </a>

            <a href="{{ route('personal.setting') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-[#023E8A] transition">
                <img src="{{ asset('images/accountSetting.png') }}" alt="Setting" style="width: 10%; height: auto;">
                Account Setting
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 overflow-y-auto">

        <!-- GOAL HEADER (dynamic) -->
        <div class="flex items-center gap-5 bg-[#E4F1FF] p-4 rounded-xl border border-blue-200 shadow mb-6">
            <div class="w-24 h-20 rounded-xl overflow-hidden bg-blue-100 flex items-center justify-center text-xs text-blue-700 font-semibold">
                @if($goal->foto)
                    <img src="{{ asset('storage/' . $goal->foto) }}" class="w-full h-full object-cover" alt="">
                @else
                    {{ $goal->nama ?? 'My Goal' }}
                @endif
            </div>

            <div>
                <h2 class="text-2xl font-bold text-[#03045E]">
                    Save to : {{ $goal->nama ?? 'My Goal' }}
                </h2>
                <p class="text-gray-700">
                    Target : Rp {{ number_format($target, 0, ',', '.') }}
                </p>
                <p class="text-gray-700">
                    Progress : {{ $progress }}%
                </p>
            </div>
        </div>

        <!-- TRANSACTION BOX -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border w-full">

            <!-- TITLE + TYPE -->
            <div class="flex items-center gap-3 mb-4">
                <h2 class="text-2xl font-bold text-[#03045E]">Transaction</h2>
                <div class="h-6 w-[2px] bg-[#03045E] opacity-40"></div>
                <h2 id="transactionType" class="text-xl font-semibold text-[#03045E]">Saving</h2>
            </div>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 px-4 py-2 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <p class="text-sm text-gray-600 mb-4">
                Choose <strong>Saving</strong> to add money, or <strong>Withdraw</strong> to record taking money from this goal.
            </p>

            <!-- TABS -->
            <div class="flex mb-5 h-10">
                <button type="button" id="btnSaving"
                    class="flex-1 font-semibold rounded-l-xl bg-[#03045E] text-white"
                    onclick="setActiveTab('saving')">
                    Saving
                </button>

                <button type="button" id="btnWithdraw"
                    class="flex-1 font-semibold rounded-r-xl bg-blue-100 text-[#03045E]"
                    onclick="setActiveTab('withdraw')">
                    Withdraw
                </button>
            </div>

            <!-- FORM (Laravel) -->
            <form method="POST" action="{{ route('personal.goals.save.store', $goal) }}" class="space-y-4">
                @csrf

                <!-- hidden jenis -->
                <input type="hidden" name="jenis" id="jenis-input" value="saving">

                <!-- DATE -->
                <div>
                    <label for="tgl_transaksi" class="font-semibold text-gray-700">Date</label>
                    <input id="tgl_transaksi" type="date" name="tgl_transaksi"
                        class="w-full border rounded-lg p-2 mt-1"
                        value="{{ old('tgl_transaksi', now()->format('Y-m-d')) }}"
                        required>
                </div>

                <!-- AMOUNT -->
                <div>
                    <label for="nominal" class="font-semibold text-gray-700">Amount (Rp)</label>
                    <input id="nominal" type="number" name="nominal" min="1"
                        class="w-full border rounded-lg p-2 mt-1"
                        value="{{ old('nominal') }}"
                        required>
                </div>

                <!-- NOTE -->
                <div>
                    <label for="keterangan" class="font-semibold text-gray-700">Note</label>
                    <textarea id="keterangan" name="keterangan"
                        class="w-full border rounded-lg p-2 mt-1 h-20"
                        placeholder="Optional note...">{{ old('keterangan') }}</textarea>
                </div>

                <!-- BUTTONS -->
                <div class="flex gap-4 mt-2">
                    <button type="submit"
                        class="w-1/2 py-2 bg-[#03045E] text-white rounded-xl font-bold hover:bg-[#050691] transition">
                        Save
                    </button>

                    <a href="{{ route('personal.goals') }}"
                        class="w-1/2 py-2 bg-gray-300 text-gray-800 text-center rounded-xl font-bold hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- HISTORY -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border w-full mt-6">
            <h3 class="text-lg font-bold text-[#03045E] mb-3">Transaction History</h3>

            @php
                $transaksis = $goal->transaksis()->latest()->get();
            @endphp

            @forelse($transaksis as $tx)
                @php $isSaving = $tx->jenis === 'saving'; @endphp

                <div class="py-3 border-b border-blue-50 last:border-b-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-sm font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($tx->tgl_transaksi)->format('d M Y') }}
                            </div>

                            @if($tx->keterangan)
                                <div class="text-xs text-gray-500 mt-1">
                                    Note: {{ $tx->keterangan }}
                                </div>
                            @endif

                            <div class="text-xs text-gray-400 mt-1">
                                {{ ucfirst($tx->jenis) }}
                            </div>
                        </div>

                        <div class="text-base font-bold {{ $isSaving ? 'text-green-600' : 'text-red-600' }}">
                            {{ $isSaving ? '+' : '-' }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">
                    Belum ada transaksi untuk goal ini. Yuk mulai nabung ✨
                </p>
            @endforelse
        </div>

    </main>

    <script>
        function setActiveTab(tab) {
            const btnSaving = document.getElementById("btnSaving");
            const btnWithdraw = document.getElementById("btnWithdraw");
            const transactionType = document.getElementById("transactionType");
            const jenisInput = document.getElementById("jenis-input");

            if (tab === "saving") {
                btnSaving.classList.add("bg-[#03045E]", "text-white");
                btnSaving.classList.remove("bg-blue-100", "text-[#03045E]");

                btnWithdraw.classList.add("bg-blue-100", "text-[#03045E]");
                btnWithdraw.classList.remove("bg-[#03045E]", "text-white");

                transactionType.textContent = "Saving";
                jenisInput.value = "saving";
            } else {
                btnWithdraw.classList.add("bg-[#03045E]", "text-white");
                btnWithdraw.classList.remove("bg-blue-100", "text-[#03045E]");

                btnSaving.classList.add("bg-blue-100", "text-[#03045E]");
                btnSaving.classList.remove("bg-[#03045E]", "text-white");

                transactionType.textContent = "Withdraw";
                jenisInput.value = "withdraw";
            }
        }
    </script>

</body>
</html>

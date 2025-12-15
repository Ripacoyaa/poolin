<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Poolin - {{ isset($goal) ? 'Edit Goal' : 'Create Goal' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <img src="{{ asset('images/setting.png') }}" alt="Setting" style="width: 10%; height: auto;">
                <span>Setting</span>
            </a>

        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 p-10 overflow-auto">

        <!-- TITLE BAR -->
        <div class="flex items-center justify-between mb-6">
            <div class="text-3xl font-bold text-[#050691]">
                {{ isset($goal) ? 'Edit Goal' : 'Create a New Goal' }}
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white shadow-lg rounded-2xl p-8">

            <form method="POST"
                  action="{{ isset($goal) ? route('personal.goals.update', $goal) : route('personal.goals.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($goal))
                    @method('PUT')
                @endif

                <!-- GRID 2 KOLOM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- KOLOM KIRI -->
                    <div class="space-y-5">

                        {{-- Goal Name --}}
                        <div class="flex flex-col">
                            <label for="nama" class="font-semibold mb-1">Goal Name</label>
                            <input
                                required
                                type="text"
                                id="nama"
                                name="nama"
                                placeholder="Your Goals"
                                value="{{ old('nama', $goal->nama ?? '') }}"
                                class="p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Target Amount --}}
                        <div class="flex flex-col">
                            <label for="target_tabungan" class="font-semibold mb-1">Target Amount (Rp)</label>
                            <input
                                required
                                type="number"
                                id="target_tabungan"
                                name="target_tabungan"
                                step="1000"
                                min="0"
                                placeholder="e.g., 10000000"
                                value="{{ old('target_tabungan', $goal->target_tabungan ?? '') }}"
                                class="p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('target_tabungan') border-red-500 @enderror">
                            @error('target_tabungan')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ✅ Target Date (optional) --}}
                        <div class="flex flex-col">
                            <label for="target_tanggal" class="font-semibold mb-1">Target Date (optional)</label>
                            <input
                                type="date"
                                id="target_tanggal"
                                name="target_tanggal"
                                value="{{ old('target_tanggal', isset($goal) && $goal->target_tanggal ? \Carbon\Carbon::parse($goal->target_tanggal)->format('Y-m-d') : '') }}"
                                class="p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('target_tanggal') border-red-500 @enderror">
                            @error('target_tanggal')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Goal Image --}}
                        <div class="flex flex-col">
                            <label for="foto" class="font-semibold mb-1">Upload Photo (optional)</label>
                            <input
                                type="file"
                                id="foto"
                                name="foto"
                                accept="image/*"
                                class="p-2 border rounded-xl bg-gray-50 @error('foto') border-red-500 @enderror">
                            @error('foto')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                            @if(isset($goal) && $goal->foto)
                                <p class="text-xs text-gray-500 mt-2">Current image:</p>
                                <img src="{{ asset('storage/'.$goal->foto) }}"
                                     alt="Goal image"
                                     class="mt-1 w-32 h-32 object-cover rounded-xl border">
                            @endif
                        </div>

                    </div>

                    <!-- KOLOM KANAN -->
                    <div class="flex flex-col h-full">
                        <label for="deskripsi" class="font-semibold mb-1">Description (optional)</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            placeholder="Describe your goal..."
                            class="p-4 border rounded-xl h-full min-h-[220px] resize-none focus:ring-2 focus:ring-blue-400 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $goal->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- STATUS (hanya saat edit) --}}
                @if(isset($goal))
                    <div class="mt-6 max-w-md">
                        <label for="status" class="font-semibold mb-1 block">Status</label>
                        <select id="status" name="status"
                                class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('status') border-red-500 @enderror">
                            <option value="active"   {{ ($goal->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="finished" {{ ($goal->status ?? '') === 'finished' ? 'selected' : '' }}>Finished</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- BUTTON AREA CENTERED -->
                <div class="flex justify-center gap-6 mt-10">
                    <button type="submit"
                            class="px-8 py-3 bg-[#050691] text-white rounded-xl font-bold hover:bg-[#03045E] transition">
                        {{ isset($goal) ? 'Update Goal' : 'Save Goal' }}
                    </button>

                    <a href="{{ route('personal.goals') }}"
                       class="px-8 py-3 bg-gray-300 text-black rounded-xl font-bold hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Save Now - {{ $goal->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #e6f6ff;
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #111a78, #1845c6);
            color: #fff;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            padding-left: 6px;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: #ffffff;
            color: #1845c6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
        }

        .nav {
            list-style: none;
            margin-top: 12px;
        }

        .nav li {
            margin-bottom: 10px;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            color: #dbe6ff;
        }

        .nav a.active {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 24px 32px;
        }

        .goal-summary {
            background: #ffffff;
            border-radius: 18px;
            padding: 16px 20px;
            display: flex;
            gap: 16px;
            align-items: center;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
        }

        .goal-img {
            width: 120px;
            height: 90px;
            border-radius: 14px;
            overflow: hidden;
            background: #d3e4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #5a6fa4;
        }

        .goal-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .goal-text-title {
            font-size: 16px;
            font-weight: 600;
            color: #294377;
        }

        .goal-text-line {
            font-size: 13px;
            color: #6a7ba3;
            margin-top: 2px;
        }

        .card {
            margin-top: 18px;
            background: #ffffff;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #294377;
            margin-bottom: 14px;
        }

        .info {
            font-size: 12px;
            color: #6a7ba3;
            margin-bottom: 12px;
        }

        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 18px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid #c3d5f5;
        }

        .tab-btn {
            flex: 1;
            padding: 10px 0;
            border: none;
            background: #f3f7ff;
            font-size: 14px;
            cursor: pointer;
            color: #4261a9;
        }

        .tab-btn.active {
            background: #1845c6;
            color: #ffffff;
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            font-size: 13px;
            color: #4b5c8e;
            margin-bottom: 4px;
            display: block;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid #c3d5f5;
            font-size: 13px;
        }

        textarea {
            min-height: 60px;
            resize: vertical;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            gap: 12px;
        }

        .btn-primary {
            flex: 1;
            border: none;
            border-radius: 999px;
            padding: 10px 0;
            background: linear-gradient(90deg, #1625b0, #2351e3);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary {
            flex: 1;
            border-radius: 999px;
            padding: 10px 0;
            border: 1px solid #c3d5f5;
            background: transparent;
            color: #294377;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .error {
            color: #d9534f;
            font-size: 12px;
            margin-bottom: 6px;
        }

        /* HISTORY */
        .history-card {
            margin-top: 18px;
            background: #ffffff;
            border-radius: 18px;
            padding: 16px 18px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
        }

        .history-title {
            font-size: 15px;
            font-weight: 600;
            color: #294377;
            margin-bottom: 8px;
        }

        .history-item {
            padding: 10px 0;
            border-bottom: 1px solid #edf2ff;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .history-date {
            font-size: 13px;
            color: #4b5c8e;
        }

        .history-note {
            font-size: 12px;
            color: #7c8bb3;
            margin-top: 2px;
        }

        .history-amount {
            font-size: 14px;
            font-weight: 600;
        }

        .history-type {
            font-size: 11px;
            margin-top: 2px;
            color: #7c8bb3;
        }

        .history-item.saving .history-amount {
            color: #1c9c5d;
        }

        .history-item.withdraw .history-amount {
            color: #e14848;
        }

        .history-empty {
            font-size: 12px;
            color: #7c8bb3;
            margin-top: 6px;
        }

        @media (max-width: 900px) {
            .sidebar {
                display: none;
            }
            .content {
                padding: 18px 14px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <div class="logo-box">
            <div class="logo-icon">P</div>
            <div class="logo-text">Poolin</div>
        </div>

        <ul class="nav">
            <li><a href="{{ route('personal.home') }}">🏠 Home</a></li>
            <li><a href="{{ route('personal.goals') }}" class="active">🎯 My Goals</a></li>
            <li><a href="{{ route('personal.report') }}">📊 Report</a></li>
            <li><a href="{{ route('personal.setting') }}">⚙️ Setting</a></li>
        </ul>
    </div>
</div>

<div class="content">

    {{-- GOAL SUMMARY --}}
    <div class="goal-summary">
        <div class="goal-img">
            @if($goal->foto)
                <img src="{{ asset('storage/' . $goal->foto) }}" alt="">
            @else
                {{ $goal->nama ?? 'My Goal' }}
            @endif
        </div>
        <div>
            <div class="goal-text-title">Save to : {{ $goal->nama ?? 'My Goal' }}</div>
            <div class="goal-text-line">
                Target : Rp {{ number_format($target, 0, ',', '.') }}
            </div>
            <div class="goal-text-line">
                Progress : {{ $progress }}%
            </div>
        </div>
    </div>

    {{-- TRANSACTION FORM --}}
    <div class="card">
        <div class="card-title">Transaction</div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="info">
            Choose <strong>Saving</strong> to add money, or <strong>Withdraw</strong> to record taking money from this goal.
        </div>

        <div class="tabs">
            <button type="button" class="tab-btn active" id="tab-saving">Saving</button>
            <button type="button" class="tab-btn" id="tab-withdraw">Withdraw</button>
        </div>

        <form method="POST" action="{{ route('personal.goals.save.store', $goal) }}">
            @csrf

            {{-- hidden jenis: saving / withdraw --}}
            <input type="hidden" name="jenis" id="jenis-input" value="saving">

            <div class="form-group">
                <label for="tgl_transaksi">Date</label>
                <input type="date" id="tgl_transaksi" name="tgl_transaksi"
                       value="{{ old('tgl_transaksi', now()->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="nominal">Amount (Rp)</label>
                <input type="number" id="nominal" name="nominal" min="1"
                       value="{{ old('nominal') }}" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Note</label>
                <textarea id="keterangan" name="keterangan"
                          placeholder="Optional note...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn-primary">Save</button>
                <a href="{{ route('personal.goals') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    {{-- HISTORY --}}
    <div class="history-card">
        <div class="history-title">Transaction History</div>

        @php
            $transaksis = $goal->transaksis()->latest()->get();
        @endphp

        @forelse($transaksis as $tx)
            @php $isSaving = $tx->jenis === 'saving'; @endphp

            <div class="history-item {{ $isSaving ? 'saving' : 'withdraw' }}">
                <div class="history-main">
                    <div>
                        <div class="history-date">
                            {{ \Carbon\Carbon::parse($tx->tgl_transaksi)->format('d M Y') }}
                        </div>
                        @if($tx->keterangan)
                            <div class="history-note">
                                Note: {{ $tx->keterangan }}
                            </div>
                        @endif
                    </div>

                    <div class="history-amount">
                        {{ $isSaving ? '+' : '-' }}
                        Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                    </div>
                </div>

                <div class="history-type">
                    {{ ucfirst($tx->jenis) }}
                </div>
            </div>
        @empty
            <p class="history-empty">
                Belum ada transaksi untuk goal ini. Yuk mulai nabung ✨
            </p>
        @endforelse
    </div>
</div>

<script>
    const tabSaving   = document.getElementById('tab-saving');
    const tabWithdraw = document.getElementById('tab-withdraw');
    const jenisInput  = document.getElementById('jenis-input');

    tabSaving.addEventListener('click', function () {
        jenisInput.value = 'saving';
        tabSaving.classList.add('active');
        tabWithdraw.classList.remove('active');
    });

    tabWithdraw.addEventListener('click', function () {
        jenisInput.value = 'withdraw';
        tabWithdraw.classList.add('active');
        tabSaving.classList.remove('active');
    });
</script>

</body>
</html>

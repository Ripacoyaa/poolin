<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - My Goals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body {
            background: #e6f6ff;
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #111a78, #1845c6);
            color: #fff;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
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
            background: #fff;
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
            flex: 1;
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
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 24px 32px 32px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-left-title {
            font-size: 20px;
            color: #294377;
            font-weight: 600;
        }

        .top-left-sub {
            font-size: 13px;
            color: #6a7ba3;
        }

        .top-right {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .mode-toggle {
            display: inline-flex;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid #c3d5f5;
        }

        .mode-toggle button {
            border: none;
            padding: 6px 18px;
            font-size: 13px;
            cursor: pointer;
            background: transparent;
            color: #4261a9;
        }

        .mode-toggle .active {
            background: #1845c6;
            color: #fff;
        }

        .btn-new-goal {
            border: none;
            padding: 8px 18px;
            border-radius: 999px;
            background: linear-gradient(90deg,#1625b0,#2351e3);
            color: #fff;
            font-size: 13px;
            cursor: pointer;
        }

        .tabs {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }

        .tab-btn {
            padding: 6px 18px;
            border-radius: 999px;
            border: 1px solid #c3d5f5;
            background: #f3f7ff;
            font-size: 12px;
            cursor: pointer;
            color: #4b5c8e;
        }

        .tab-btn.active {
            background: #1845c6;
            color: #fff;
            border-color: #1845c6;
        }

        .goals-section {
            margin-top: 16px;
        }

        .goal-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 18px 18px 20px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .goal-image {
            width: 100%;
            height: 120px;
            border-radius: 14px;
            background: #d3e4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #5a6fa4;
        }

        .goal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .goal-title {
            font-size: 16px;
            font-weight: 600;
            color: #294377;
        }

        .goal-meta {
            font-size: 11px;
            color: #8b98c0;
            margin-top: 2px;
        }

        .goal-actions {
            font-size: 14px;
            display: flex;
            gap: 8px;
            color: #9aa6c8;
        }

        .goal-desc {
            margin-top: 6px;
            font-size: 12px;
            color: #6a7ba3;
        }

        .progress-bar-wrapper {
            margin-top: 10px;
        }

        .progress-label {
            font-size: 11px;
            color: #6a7ba3;
            margin-bottom: 4px;
        }

        .progress-bar {
            width: 100%;
            background: #e0ebff;
            border-radius: 999px;
            height: 8px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 87%;
            border-radius: 999px;
            background: linear-gradient(90deg,#1845c6,#33c4ff);
        }

        .goal-stats {
            margin-top: 12px;
            display: flex;
            gap: 12px;
        }

        .goal-stat-box {
            flex: 1;
            background: #f3f7ff;
            border-radius: 16px;
            padding: 10px 12px;
            font-size: 11px;
            color: #6a7ba3;
            text-align: center;
        }

        .goal-stat-label {
            font-size: 11px;
            color: #6a7ba3;
            margin-bottom: 4px;
        }

        .goal-stat-value {
            font-size: 14px;
            font-weight: 600;
            color: #294377;
        }

        .btn-save-now {
            margin-top: 14px;
            width: 100%;
            border: none;
            padding: 9px 0;
            border-radius: 999px;
            background: linear-gradient(90deg,#1625b0,#2351e3);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .achieved-box {
            margin-top: 20px;
            background: #ffffff;
            border-radius: 18px;
            padding: 16px 18px 18px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
        }

        .achieved-title {
            font-size: 14px;
            font-weight: 600;
            color: #294377;
            margin-bottom: 10px;
        }

        .achieved-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #edf1ff;
        }

        .achieved-name {
            font-weight: 600;
            color: #344979;
        }

        .achieved-meta {
            font-size: 11px;
            color: #8b98c0;
        }

        .achieved-amount {
            font-size: 13px;
            font-weight: 600;
            color: #294377;
        }

        .goal-filters {
            display: inline-flex;
            gap: 8px;
            margin-bottom: 16px;
            background: #e4f2ff;
            padding: 4px;
            border-radius: 999px;
        }

        .filter-pill {
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            text-decoration: none;
            color: #294377;
            background: transparent;
        }

        .filter-pill.active {
            background: #1845c6;
            color: #ffffff;
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
    <div class="top-bar">
        <div>
            <div class="top-left-title">My Goals</div>
            <div class="top-left-sub">Manage all your savings goals.</div>
        </div>

        <div class="top-right">
            <div class="mode-toggle">
                <button class="active">Personal</button>
                <button onclick="window.location.href='{{ route('group.home') }}'">Group</button>
            </div>
            <button class="btn-new-goal"
            onclick="window.location.href='{{route('personal.goals.create') }}'">
                + Create a New Goal
            </button>
            <form class="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="border-radius:999px;border:1px solid #c3d5f5;background:transparent;padding:6px 14px;font-size:12px;cursor:pointer;">Logout</button>
            </form>
        </div>
    </div>

    <div class="goals-section">

    @if(session('success'))
        <div style="margin-bottom:10px;font-size:12px;color:green;">
            {{ session('success') }}
        </div>
    @endif

    <div class="goal-filters">
    <a href="{{ route('personal.goals', ['status' => 'active']) }}"
       class="filter-pill {{ $statusFilter === 'active' ? 'active' : '' }}">
        Active
    </a>

    <a href="{{ route('personal.goals', ['status' => 'finished']) }}"
       class="filter-pill {{ $statusFilter === 'finished' ? 'active' : '' }}">
        Finished
    </a>

    <a href="{{ route('personal.goals', ['status' => 'all']) }}"
       class="filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
        All
    </a>
</div>

@forelse($goals as $goal)
    {{-- kartu goal kamu di sini --}}
@empty
    <p style="margin-top:12px; color:#7c8bb3; font-size:13px;">
        Belum ada goal pada kategori ini.
    </p>
@endforelse

    @forelse($goals as $goal)
        @php
            $target = $goal->target_tabungan ?? 0;
            $collected = $goal->total_terkumpul ?? 0;
            $progress = $target > 0 ? min(100, round($collected / $target * 100)) : 0;
            $moneyLeft = max(0, $target - $collected);
        @endphp

        <div class="goal-card">
            @if($goal->foto)
    <div class="goal-image" style="padding:0;">
        <img src="{{ asset('storage/' . $goal->foto) }}" 
             style="width:100%; height:120px; object-fit:cover; border-radius:14px;">
    </div>
@else
    <div class="goal-image">
        {{ $goal->nama ?? 'My Goal' }}
    </div>
@endif

            <div>
                <div class="goal-header">
                    <div>
                        <div class="goal-title">{{ $goal->nama ?? 'My Goal' }}</div>
                        <div class="goal-meta">
                            Status: {{ ucfirst($goal->status) }}
                        </div>
                    </div>

                    <div class="goal-actions">
                        <a href="{{ route('personal.goals.edit', $goal) }}">✏️</a>

                        <form action="{{ route('personal.goals.destroy', $goal) }}"
                              method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Hapus goal ini?')"
                                    style="border:none;background:none;cursor:pointer;">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>

                <div class="goal-desc">
                    Target: Rp {{ number_format($target, 0, ',', '.') }},
                    Terkumpul: Rp {{ number_format($collected, 0, ',', '.') }}
                </div>

                <div class="progress-bar-wrapper">
                    <div class="progress-label">Progress — {{ $progress }}%</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                    </div>
                </div>

                <div class="goal-stats">
                    <div class="goal-stat-box">
                        <div class="goal-stat-label">Collected</div>
                        <div class="goal-stat-value">
                            Rp {{ number_format($collected, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="goal-stat-box">
                        <div class="goal-stat-label">Money Left</div>
                        <div class="goal-stat-value">
                            Rp {{ number_format($moneyLeft, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="goal-stat-box">
                        <div class="goal-stat-label">Target</div>
                        <div class="goal-stat-value">
                            Rp {{ number_format($target, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <button class="btn-save-now"
                        onclick="window.location.href='{{ route('personal.goals.save', $goal) }}'">
                Save Now
                </button>
            </div>
        </div>
    @empty
        <p style="font-size:13px;color:#6a7ba3;margin-top:10px;">
            Kamu belum punya goal. Yuk buat satu dengan klik "Create a New Goal" 😊
        </p>
    @endforelse

        <!-- Goals Achieved -->
        <div class="achieved-box">
            <div class="achieved-title">Goals Achieved</div>

            <div class="achieved-item">
                <div>
                    <div class="achieved-name">iPhone 16 Pro Max</div>
                    <div class="achieved-meta">Finished 2025-02-19 · 100% achieved</div>
                </div>
                <div class="achieved-amount">Rp 25.999.000</div>
            </div>

            <div class="achieved-item">
                <div>
                    <div class="achieved-name">Umroh Bareng Keluarga</div>
                    <div class="achieved-meta">Finished 2025-03-02 · 100% achieved</div>
                </div>
                <div class="achieved-amount">Rp 162.000.000</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

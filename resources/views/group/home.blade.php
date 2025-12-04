<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Group Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family:"Poppins",sans-serif; }

        body {
            background:#e6f6ff;
            min-height:100vh;
            display:flex;
        }

        /* SIDEBAR */
        .sidebar {
            width:230px;
            background:linear-gradient(180deg,#111a78,#1845c6);
            color:#fff;
            padding:24px 18px;
            display:flex;
            flex-direction:column;
        }

        .logo-box {
            display:flex;align-items:center;gap:10px;
            margin-bottom:32px;padding-left:6px;
        }

        .logo-icon {
            width:34px;height:34px;border-radius:12px;
            background:#fff;color:#1845c6;
            display:flex;align-items:center;justify-content:center;
            font-weight:700;
        }

        .logo-text { font-size:22px;font-weight:700; }

        .nav { list-style:none;margin-top:12px;flex:1; }
        .nav li { margin-bottom:10px; }
        .nav a {
            display:flex;align-items:center;gap:8px;
            padding:10px 12px;
            border-radius:12px;
            text-decoration:none;
            font-size:14px;
            color:#dbe6ff;
        }
        .nav a.active {
            background:rgba(255,255,255,0.15);
            color:#fff;
        }

        /* CONTENT */
        .content {
            flex:1;
            padding:24px 32px 32px;
        }

        .top-bar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:18px;
        }

        .top-left-title {
            font-size:20px;
            color:#294377;
            font-weight:600;
        }
        .top-left-sub {
            font-size:13px;
            color:#6a7ba3;
        }

        .top-right {
            display:flex;
            gap:12px;
            align-items:center;
        }

        .mode-toggle {
            display:inline-flex;
            border-radius:999px;
            overflow:hidden;
            border:1px solid #c3d5f5;
        }
        .mode-toggle button {
            border:none;
            padding:6px 18px;
            font-size:13px;
            cursor:pointer;
            background:transparent;
            color:#4261a9;
        }
        .mode-toggle .active {
            background:#1845c6;
            color:#fff;
        }

        .logout-btn {
            border-radius:999px;
            border:1px solid #c3d5f5;
            background:transparent;
            padding:6px 14px;
            font-size:12px;
            cursor:pointer;
        }

        /* SUMMARY CARDS ROW */
        .summary-row {
            display:grid;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            gap:18px;
        }

        .summary-card {
            background:#ffffff;
            border-radius:18px;
            padding:14px 16px;
            box-shadow:0 10px 24px rgba(0,0,0,0.06);
            font-size:13px;
            color:#42558a;
        }

        .summary-label {
            font-size:12px;
            color:#6a7ba3;
            margin-bottom:4px;
        }

        .summary-value {
            font-size:18px;
            font-weight:700;
            color:#284276;
        }

        /* MAIN LAYOUT */
        .main-row {
            display:grid;
            grid-template-columns: 2.2fr 1.2fr;
            gap:18px;
            margin-top:20px;
        }

        .panel {
            background:#ffffff;
            border-radius:18px;
            padding:18px 20px;
            box-shadow:0 10px 24px rgba(0,0,0,0.06);
        }

        .panel-header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:8px;
        }

        .panel-title {
            font-size:14px;
            font-weight:600;
            color:#294377;
        }

        .panel-sub {
            font-size:11px;
            color:#7a8bb1;
        }

        /* QUICK ACTIONS */
        .quick-actions {
            display:flex;
            gap:10px;
            margin-top:10px;
        }

        .quick-btn {
            flex:1;
            border-radius:999px;
            border:none;
            padding:8px 0;
            font-size:13px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:6px;
        }

        .btn-outline {
            background:#f3f7ff;
            color:#294377;
            border:1px solid #c3d5f5;
        }

        .btn-primary {
            background:linear-gradient(90deg,#1625b0,#2351e3);
            color:#fff;
        }

        /* ROOM CARDS */
        .room-list {
            margin-top:14px;
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .room-card {
            background:#f5f8ff;
            border-radius:14px;
            padding:10px 12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-size:12px;
        }

        .room-left {
            display:flex;
            flex-direction:column;
            gap:2px;
        }

        .room-name {
            font-weight:600;
            color:#294377;
        }

        .room-meta {
            color:#7c8bb3;
            font-size:11px;
        }

        .room-right {
            text-align:right;
            font-size:11px;
        }

        .room-amount {
            font-weight:600;
            color:#294377;
        }

        .room-link {
            margin-top:4px;
            font-size:11px;
        }
        .room-link a {
            color:#1845c6;
            text-decoration:none;
            font-weight:500;
        }

        /* RIGHT PANELS */
        .activity-list {
            list-style:none;
            margin-top:10px;
            max-height:220px;
        }

        .activity-item {
            display:flex;
            justify-content:space-between;
            font-size:12px;
            padding:6px 0;
            border-bottom:1px solid #edf1ff;
        }

        .activity-item span.time {
            color:#9aa6c8;
            font-size:11px;
            white-space:nowrap;
            margin-left:8px;
        }

        .footer-text {
            margin-top:16px;
            font-size:12px;
            color:#6a7ba3;
            text-align:center;
        }

        @media(max-width:900px){
            .sidebar{display:none;}
            .content{padding:18px 14px;}
            .summary-row{grid-template-columns:1fr;}
            .main-row{grid-template-columns:1fr;}
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    <div>
        <div class="logo-box">
            <div class="logo-icon">P</div>
            <div class="logo-text">Poolin</div>
        </div>

        <ul class="nav">
            <li><a href="{{ route('group.home') }}" class="active">🏠 Group Home</a></li>
            <li><a href="#">👥 My Rooms</a></li>
            <li><a href="#">💰 Contributions</a></li>
           <li><a href="{{ route('personal.setting') }}">⚙️ Setting</a></li>
        </ul>
    </div>
</div>

{{-- CONTENT --}}
<div class="content">
    <div class="top-bar">
        <div>
            <div class="top-left-title">Group Home</div>
            <div class="top-left-sub">
                Hi {{ $user->name }}, kelola semua group savings yang kamu ikuti di sini.
            </div>
        </div>

        <div class="top-right">
            <div class="mode-toggle">
                <button onclick="window.location.href='{{ route('personal.home') }}'">Personal</button>
                <button class="active">Group</button>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    {{-- SUMMARY --}}
    @php
        $totalRooms = $rooms->count();
        $activeRooms = $rooms->count(); // kalau nanti ada kolom status, bisa difilter
        $totalBalance = 0; // placeholder, nanti bisa diganti total contribution semua room
    @endphp

    <div class="summary-row">
        <div class="summary-card">
            <div class="summary-label">Total Rooms</div>
            <div class="summary-value">{{ $totalRooms }}</div>
            <div class="summary-sub">Rooms yang kamu buat / ikuti</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">This Month Contribution</div>
            <div class="summary-value">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
            <div class="summary-sub">Placeholder: nanti bisa dihitung dari transaksi</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Active Rooms</div>
            <div class="summary-value">{{ $activeRooms }}</div>
            <div class="summary-sub">Room group yang sedang berjalan</div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="main-row">
        {{-- LEFT: Your Rooms --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Your Rooms</div>
                    <div class="panel-sub">Daftar room tabungan bareng kamu.</div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="quick-actions">
                <button class="quick-btn btn-outline"
                        onclick="window.location.href='{{ route('group.join') }}'">
                    ➕ Join room
                </button>
                <button class="quick-btn btn-primary"
                        onclick="window.location.href='{{ route('group.create') }}'">
                    🏠 Create a new room
                </button>
            </div>

            {{-- List Rooms --}}
            <div class="room-list">
                @forelse($rooms as $room)
                    <div class="room-card">
                        <div class="room-left">
                            <div class="room-name">{{ $room->nama_room }}</div>
                            <div class="room-meta">
                                Kode: <strong>{{ $room->kode_room }}</strong> ·
                                Dibuat: {{ optional($room->tgl_buat)->format('d/m/Y') ?? '-' }}
                            </div>
                            @if($room->deskripsi)
                                <div class="room-meta">{{ $room->deskripsi }}</div>
                            @endif
                        </div>
                        <div class="room-right">
                            <div class="room-amount">
                                {{-- placeholder total saldo room --}}
                                Rp 0
                            </div>
                            <div class="room-link">
                                <a href="{{ route('group.room.show', $room) }}">
                                    Lihat room →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="margin-top:16px;font-size:13px;color:#6a7ba3;">
                        Kamu belum punya group room. Yuk buat room baru atau join dengan kode
                        yang dibagi temanmu ✨
                    </p>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: Top Contributor & Activity (placeholder dulu) --}}
        <div>
            <div class="panel" style="margin-bottom:18px;">
                <div class="panel-header">
                    <div class="panel-title">Top Contributor of the Month</div>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <span>Andi Wijaya</span>
                        <span class="time">Rp3.500.000</span>
                    </li>
                    <li class="activity-item">
                        <span>Siti Nurhaliza</span>
                        <span class="time">Rp2.300.000</span>
                    </li>
                    <li class="activity-item">
                        <span>Budi Santoso</span>
                        <span class="time">Rp1.800.000</span>
                    </li>
                </ul>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Recent Activity</div>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <span>Amel deposited ke room "Office Lottery"</span>
                        <span class="time">Rp150.000 · 2h ago</span>
                    </li>
                    <li class="activity-item">
                        <span>Dito joined room "Family Vacation"</span>
                        <span class="time">1d ago</span>
                    </li>
                    <li class="activity-item">
                        <span>Room "Gift for Boss" updated target</span>
                        <span class="time">3d ago</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-text">
        “Saving together is easier — manage all your group rooms in one place.”
    </div>
</div>

</body>
</html>

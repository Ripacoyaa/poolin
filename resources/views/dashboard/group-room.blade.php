<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group Home - {{ $room->nama_room }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family:"Poppins",sans-serif; }
        body { background:#e6f6ff; min-height:100vh; display:flex; }

        .sidebar {
            width:230px;
            background:linear-gradient(180deg,#111a78,#1845c6);
            color:#fff;
            padding:24px 18px;
            display:flex;
            flex-direction:column;
        }
        .logo-box { display:flex;align-items:center;gap:10px;margin-bottom:32px;padding-left:6px; }
        .logo-icon {
            width:34px;height:34px;border-radius:12px;
            background:#fff;color:#1845c6;
            display:flex;align-items:center;justify-content:center;font-weight:700;
        }
        .logo-text { font-size:22px;font-weight:700; }
        .nav { list-style:none;margin-top:12px;flex:1; }
        .nav li { margin-bottom:10px; }
        .nav a {
            display:flex;align-items:center;gap:8px;
            padding:10px 12px;border-radius:12px;
            text-decoration:none;font-size:14px;color:#dbe6ff;
        }
        .nav a.active { background:rgba(255,255,255,0.15);color:#fff; }

        .content { flex:1;padding:24px 32px; }

        .top-bar { display:flex;justify-content:space-between;align-items:center;margin-bottom:18px; }
        .top-left-title { font-size:20px;color:#294377;font-weight:600; }
        .top-left-sub { font-size:13px;color:#6a7ba3; }

        .top-right { display:flex;gap:12px;align-items:center; }
        .mode-toggle {
            display:inline-flex;border-radius:999px;overflow:hidden;
            border:1px solid #c3d5f5;
        }
        .mode-toggle button {
            border:none;padding:6px 18px;font-size:13px;cursor:pointer;
            background:transparent;color:#4261a9;
        }
        .mode-toggle .active { background:#1845c6;color:#fff; }

        .logout-form button {
            border-radius:999px;border:1px solid #c3d5f5;
            padding:6px 14px;background:transparent;font-size:12px;cursor:pointer;
        }

        .stats-row {
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:14px;margin-bottom:16px;
        }
        .stat-card {
            background:#fff;border-radius:14px;padding:10px 14px;
            box-shadow:0 8px 20px rgba(0,0,0,0.05);
            font-size:12px;color:#4b5c8e;
        }
        .stat-label { font-size:11px;color:#7c8bb3;margin-bottom:4px; }
        .stat-value { font-size:18px;font-weight:600;color:#22366b; }

        .main-row { display:grid;grid-template-columns:2.1fr 1.2fr;gap:18px; }
        .panel {
            background:#fff;border-radius:18px;padding:14px 16px;
            box-shadow:0 10px 24px rgba(0,0,0,0.06);
        }
        .panel-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:10px; }
        .panel-title { font-size:14px;font-weight:600;color:#294377; }
        .panel-sub { font-size:11px;color:#7a8bb1; }

        .quick-actions { display:flex;gap:10px;margin-top:8px; }
        .qa-btn {
            flex:1;border-radius:999px;border:1px solid #c3d5f5;
            padding:8px 10px;font-size:12px;cursor:pointer;
            background:#f3f7ff;color:#294377;text-align:center;
        }

        .room-progress-label { font-size:11px;color:#7c8bb3;margin:6px 0 2px; }
        .room-progress-bar {
            width:100%;height:8px;border-radius:999px;
            background:#e0ebff;overflow:hidden;
        }
        .room-progress-fill {
            height:100%;border-radius:999px;
            background:linear-gradient(90deg,#1845c6,#33c4ff);
        }
        .room-amounts { display:flex;justify-content:space-between;font-size:11px;margin-top:4px;color:#6a7ba3; }

        .recent-list { margin-top:6px;font-size:12px; }
        .recent-item {
            display:flex;justify-content:space-between;align-items:flex-start;
            padding:6px 0;border-bottom:1px solid #edf1ff;
        }
        .recent-left span.date { font-size:11px;color:#9aa6c8;display:block; }
        .recent-amount { font-size:12px;font-weight:600; }
        .recent-amount.plus { color:#1c9c5d; }
        .recent-amount.minus { color:#e14848; }

        @media(max-width:900px){
            .sidebar{display:none;}
            .content{padding:18px 14px;}
            .stats-row{grid-template-columns:1fr;}
            .main-row{grid-template-columns:1fr;}
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
            <li><a href="{{ route('group.room', $room) }}" class="active">🏠 Home</a></li>
            <li><a href="{{ route('group.choose') }}">🏘 My Rooms</a></li>
            <li><a href="#">💰 Contribution</a></li>
            <li><a href="{{ route('personal.setting') }}">⚙️ Setting</a></li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="top-bar">
        <div>
            <div class="top-left-title">Home Group – {{ $room->nama_room }}</div>
            <div class="top-left-sub">
                Room code: {{ $room->kode_room }} · Hi {{ auth()->user()->name }}!
            </div>
        </div>

        <div class="top-right">
            <div class="mode-toggle">
                <button onclick="window.location.href='{{ route('personal.home') }}'">Personal</button>
                <button class="active">Group</button>
            </div>
            <form class="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    {{-- contoh stat dummy, nanti bisa diisi dari controller --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Contribution</div>
            <div class="stat-value">Rp 0</div>
            <div class="stat-label">Untuk room ini</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Members</div>
            <div class="stat-value">-</div>
            <div class="stat-label">(nanti kalau sudah ada tabel anggota)</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Goals in this Room</div>
            <div class="stat-value">0</div>
            <div class="stat-label">Tabungan bareng</div>
        </div>
    </div>

    <div class="main-row">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">This Room</div>
                    <div class="panel-sub">Progress & quick actions</div>
                </div>
            </div>

            <div class="quick-actions">
                <button class="qa-btn">💰 Deposit to this room</button>
                <button class="qa-btn">📤 Withdraw (nanti)</button>
            </div>

            <div style="margin-top:12px;">
                <div class="room-progress-label">Contribution — 0%</div>
                <div class="room-progress-bar">
                    <div class="room-progress-fill" style="width:0%;"></div>
                </div>
                <div class="room-amounts">
                    <span>Collected: Rp 0</span>
                    <span>Target: Rp 0</span>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Recent Activity</div>
            </div>

            <div class="recent-list">
                <div style="font-size:12px;color:#7c8bb3;">
                    Belum ada aktivitas. Nanti diisi dari tabel transaksi group.
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

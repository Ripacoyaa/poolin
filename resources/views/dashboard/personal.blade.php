<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Personal Dashboard</title>
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
            padding: 24px 32px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .top-left h3 {
            font-size: 20px;
            color: #294377;
        }

        .top-left span {
            font-size: 14px;
            color: #6a7ba3;
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

        .logout-form button {
            border-radius: 999px;
            border: 1px solid #c3d5f5;
            padding: 6px 16px;
            background: transparent;
            font-size: 13px;
            cursor: pointer;
            margin-left: 12px;
        }

        .cards-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 18px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 14px 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
            font-size: 13px;
            color: #42558a;
        }

        .card-title {
            font-size: 12px;
            color: #6a7ba3;
            margin-bottom: 4px;
        }

        .card-main {
            font-size: 18px;
            font-weight: 700;
            color: #284276;
        }

        .card-sub {
            font-size: 12px;
            margin-top: 4px;
            color: #6a7ba3;
        }

        .main-row {
            display: grid;
            grid-template-columns: 2.3fr 1.3fr;
            gap: 18px;
            margin-top: 20px;
        }

        .panel {
            background: #ffffff;
            border-radius: 18px;
            padding: 18px 20px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .panel-title {
            font-size: 14px;
            font-weight: 600;
            color: #294377;
        }

        .panel-sub {
            font-size: 11px;
            color: #7a8bb1;
        }

        .chart-placeholder {
            height: 220px;
            border-radius: 14px;
            background: linear-gradient(180deg, #f4f7ff, #e3eeff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8a9acc;
            font-size: 13px;
        }

        .activity-list {
            list-style: none;
            margin-top: 10px;
            max-height: 220px;
        }

        .activity-item {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            padding: 6px 0;
            border-bottom: 1px solid #edf1ff;
        }

        .activity-item span.time {
            color: #9aa6c8;
            font-size: 11px;
            white-space: nowrap;
            margin-left: 8px;
        }

        .footer-text {
            margin-top: 16px;
            font-size: 12px;
            color: #6a7ba3;
            text-align: center;
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
                <li><a href="{{ route('personal.home') }}" class="active">🏠 Home</a></li>
                <li><a href="{{ route('personal.goals') }}">🎯 My Goals</a></li>
                <li><a href="{{ route('personal.report') }}" class="{{ request()->routeIs('personal.report') ? 'active' : '' }}">📊 Report</a></li>
                <li><a href="{{ route('personal.setting') }}">⚙️ Setting</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="top-bar">
            <div class="top-left">
                <h3>Home</h3>
                <span>Hi {{ auth()->user()->name }}!</span>
            </div>

            <div>
                <div class="mode-toggle">
                    <button class="active">Personal</button>
                    <button onclick="window.location.href='{{ route('group.home') }}'">Group</button>
                </div>

                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

        <div class="cards-row">
            <div class="card">
                <div class="card-title">Saving Streak</div>
                <div class="card-main">🔥 5 days</div>
                <div class="card-sub">Laptop goal</div>
            </div>

            <div class="card">
                <div class="card-title">Goal Highlight</div>
                <div class="card-main">Laptop</div>
                <div class="card-sub">Progress goal tertinggi</div>
            </div>

            <div class="card">
                <div class="card-title">Nearest Goal</div>
                <div class="card-main">Trip Bandung</div>
                <div class="card-sub">31/12/2025</div>
            </div>
        </div>

        <div class="main-row">
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Savings Progress</div>
                        <div class="panel-sub">Overview your savings performance</div>
                    </div>
                    <span class="panel-sub">2025</span>
                </div>

                <div class="chart-placeholder">
                    (Chart nabung nanti taruh di sini)
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">New Activity</div>
                </div>

                <ul class="activity-list">
                    <li class="activity-item">
                        <span>Menabung Rp100.000 ke “Laptop”</span>
                        <span class="time">2 h lalu</span>
                    </li>
                    <li class="activity-item">
                        <span>Membuat goal “Beli Rumah”</span>
                        <span class="time">5 h lalu</span>
                    </li>
                    <li class="activity-item">
                        <span>Update target goal “Liburan Bali”</span>
                        <span class="time">5 h lalu</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-text">
            “Manage Your Finances Easily with Real-Time Savings Reports.”
        </div>
    </div>
</body>
</html>

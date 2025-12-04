<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family:"Poppins",sans-serif; }

        body {
            background:#e6f6ff;
            min-height:100vh;
            display:flex;
        }

        .sidebar {
            width:230px;
            background:linear-gradient(180deg,#111a78,#1845c6);
            color:#fff;
            padding:24px 18px;
            display:flex;
            flex-direction:column;
        }

        .logo-box {
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:32px;
            padding-left:6px;
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
            padding:10px 12px;border-radius:12px;
            text-decoration:none;font-size:14px;
            color:#dbe6ff;
        }
        .nav a.active { background:rgba(255,255,255,0.15);color:#fff; }

        .content {
            flex:1;
            padding:24px 32px 32px;
        }

        .top-bar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:22px;
        }

        .top-title {
            font-size:22px;
            font-weight:700;
            color:#294377;
        }
        .top-sub {
            font-size:13px;
            color:#6a7ba3;
            margin-top:4px;
        }

        .top-actions {
            display:flex;
            gap:10px;
        }
        .btn-outline {
            border-radius:999px;
            border:1px solid #c3d5f5;
            padding:6px 16px;
            background:transparent;
            font-size:13px;
            cursor:pointer;
            color:#294377;
        }
        .btn-primary {
            border-radius:999px;
            border:none;
            padding:6px 18px;
            background:linear-gradient(90deg,#1625b0,#2351e3);
            color:#fff;
            font-size:13px;
            cursor:pointer;
        }

        .settings-list {
            margin-top:8px;
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .setting-card {
            background:#fff;
            border-radius:18px;
            padding:14px 18px;
            display:flex;
            align-items:center;
            gap:14px;
            box-shadow:0 8px 20px rgba(0,0,0,0.06);
        }

        .setting-icon {
            width:36px;height:36px;border-radius:999px;
            background:#e6f1ff;
            display:flex;align-items:center;justify-content:center;
            font-size:18px;
        }

        .setting-title {
            font-size:16px;
            font-weight:600;
            color:#294377;
        }
        .setting-desc {
            font-size:12px;
            color:#6a7ba3;
            margin-top:3px;
        }

        /* logout card spesial */
        .setting-card.logout {
            border-left:4px solid #e24c4c;
            cursor:pointer;
        }
        .setting-card.logout .setting-title {
            color:#e24c4c;
        }

        @media(max-width:900px){
            .sidebar{display:none;}
            .content{padding:18px 16px;}
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
            <li><a href="{{ route('group.home') }}" class="active">🏠 Group Home</a></li>
            <li><a href="#">👥 My Rooms</a></li>
            <li><a href="#">💰 Contributions</a></li>
           <li><a href="{{ route('personal.setting') }}">⚙️ Setting</a></li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="top-bar">
        <div>
            <div class="top-title">Settings</div>
            <div class="top-sub">
                Manage your saving preferences, account settings, and app configuration.
            </div>
        </div>
        <div class="top-actions">
            <button class="btn-outline">Cancel</button>
            <button class="btn-primary">Save Changes</button>
        </div>
    </div>

    <div class="settings-list">
        <div class="setting-card">
            <div class="setting-icon">👤</div>
            <div>
                <div class="setting-title">Account Settings</div>
                <div class="setting-desc">
                    Update your profile details, change your password, and manage login preferences.
                </div>
            </div>
        </div>

        <div class="setting-card">
            <div class="setting-icon">👥</div>
            <div>
                <div class="setting-title">Group Settings</div>
                <div class="setting-desc">
                    Manage your shared saving rooms, permissions, and group notifications.
                </div>
            </div>
        </div>

        <div class="setting-card">
            <div class="setting-icon">🔔</div>
            <div>
                <div class="setting-title">Notifications</div>
                <div class="setting-desc">
                    Customize app alerts, reminders, and updates for both personal and group savings.
                </div>
            </div>
        </div>

        <div class="setting-card">
            <div class="setting-icon">🎨</div>
            <div>
                <div class="setting-title">Appearance</div>
                <div class="setting-desc">
                    Configure reporting preferences, summaries, and how your data is displayed.
                </div>
            </div>
        </div>

        <div class="setting-card">
            <div class="setting-icon">❓</div>
            <div>
                <div class="setting-title">Help &amp; Support</div>
                <div class="setting-desc">
                    Get assistance, read FAQs, or contact our support team.
                </div>
            </div>
        </div>

        {{-- LOGOUT CARD --}}
        <div class="setting-card logout"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="setting-icon">🚪</div>
            <div>
                <div class="setting-title">Logout</div>
                <div class="setting-desc">
                    Sign out from your Poolin account.
                </div>
            </div>
        </div>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>

    </div>
</div>

</body>
</html>

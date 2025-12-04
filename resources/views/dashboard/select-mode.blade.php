<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Select Mode</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #e6f6ff;
        }

        .wrapper {
            width: 100%;
            max-width: 1100px;
            background: linear-gradient(135deg, #111a78, #1845c6);
            border-radius: 28px;
            padding: 40px 60px;
            color: #fff;
            box-shadow: 0 18px 40px rgba(0,0,0,0.25);
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.7);
            padding: 6px 18px;
            border-radius: 999px;
            color: #fff;
            cursor: pointer;
            font-size: 13px;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        p.subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 40px;
        }

        .cards {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 260px;
            background: #e4f7ff;
            border-radius: 24px;
            padding: 24px 24px 28px;
            color: #163266;
            text-align: center;
            box-shadow: 0 14px 28px rgba(0,0,0,0.18);
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .card-desc {
            font-size: 13px;
            line-height: 1.5;
        }

        .card a {
            display: inline-block;
            margin-top: 18px;
            padding: 8px 20px;
            border-radius: 999px;
            background: linear-gradient(90deg, #1625b0, #2351e3);
            color: #fff;
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="top-bar">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>

    <h1>Welcome Back, {{ auth()->user()->name }} 👋</h1>
    <h2>Where do you want to go today?</h2>
    <p class="subtitle">
        Choose your saving space to start managing your goals.
    </p>

    <div class="cards">
        <div class="card">
            <div class="card-title">Personal Savings</div>
            <div class="card-desc">
                Manage your own saving goals easily. Track your deposits and achievements, all in one place.
            </div>
            <a href="{{ route('personal.home') }}">Go to Personal</a>
        </div>

        <div class="card">
            <div class="card-title">Group Savings</div>
            <div class="card-desc">
                Create or join a shared saving room with friends or family. Save together, stay transparent.
            </div>
            <a href="{{ route('group.home') }}">Go to Group</a>
        </div>
    </div>
</div>
</body>
</html>

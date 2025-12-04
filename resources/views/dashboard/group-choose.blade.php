<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Group Mode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:"Poppins",sans-serif;}
        body{
            min-height:100vh;
            background:linear-gradient(150deg,#111a78,#1845c6);
            display:flex;align-items:center;justify-content:center;
            color:#fff;
        }
        .card{
            width:360px;
            background:#e4f7ff;
            border-radius:18px;
            padding:22px 24px 28px;
            box-shadow:0 16px 40px rgba(0,0,0,0.35);
            text-align:center;
            color:#163266;
        }
        .title{font-size:20px;font-weight:700;margin-bottom:4px;}
        .subtitle{font-size:13px;color:#5f729e;margin-bottom:18px;}
        .btn{
            width:100%;padding:10px 0;
            border-radius:999px;border:none;
            font-size:14px;font-weight:600;cursor:pointer;
            margin-top:10px;
        }
        .btn-primary{
            background:linear-gradient(90deg,#1625b0,#2351e3);
            color:#fff;
        }
        .btn-outline{
            background:#fff;border:1px solid #c3d5f5;color:#1845c6;
        }
        .top-bar{
            position:absolute;top:18px;right:24px;
            font-size:13px;
        }
        .top-bar form{display:inline;}
        .top-bar button{
            border-radius:999px;border:1px solid #c3d5f5;
            background:transparent;color:#fff;
            padding:4px 10px;font-size:12px;cursor:pointer;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

<div class="card">
    <div class="title">Choose one</div>
    <div class="subtitle">Join an existing saving room or create a new one.</div>

    <button class="btn btn-primary"
            onclick="window.location.href='{{ route('group.home') }}'">
        Join Room
    </button>

    <button class="btn btn-outline"
            onclick="window.location.href='{{ route('group.home') }}'">
        Create Room
    </button>
</div>

</body>
</html>

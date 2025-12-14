<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Created - Poolin</title>
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
            width:360px;background:#e4f7ff;border-radius:18px;
            padding:22px 24px 26px;text-align:center;
            color:#163266;box-shadow:0 16px 40px rgba(0,0,0,0.35);
        }
        .title{font-size:18px;font-weight:700;margin-bottom:6px;}
        .subtitle{font-size:13px;color:#5f729e;margin-bottom:16px;}
        .code-box{
            border-radius:999px;border:1px dashed #1845c6;
            padding:10px 0;margin-bottom:14px;
            font-size:18px;font-weight:700;letter-spacing:2px;
            background:#fff;
        }
        .btn{
            width:100%;padding:10px 0;border-radius:999px;border:none;
            background:linear-gradient(90deg,#1625b0,#2351e3);
            color:#fff;font-size:14px;font-weight:600;cursor:pointer;
            margin-top:4px;
        }
        .hint{font-size:12px;color:#5f729e;margin-bottom:10px;}
    </style>
</head>
<body>

<div class="card">
    <div class="title">Room successfully created</div>
    <div class="subtitle">Share this code with your friends so they can join</div>

    <div class="code-box">
        {{ $room->kode_room }}
    </div>

    <div class="hint">
        Room: <strong>{{ $room->nama_room }}</strong>
    </div>

    <button class="btn"
            onclick="window.location.href='{{ route('group.home', $room) }}'">
        Enter the room
    </button>
</div>

</body>
</html>

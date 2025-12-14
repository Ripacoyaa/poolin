<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Room - Poolin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* mirip join, cuma judul & field beda */
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
        .title{font-size:20px;font-weight:700;margin-bottom:4px;}
        .subtitle{font-size:13px;color:#5f729e;margin-bottom:18px;}
        input,textarea{
            width:100%;border-radius:14px;border:1px solid #c3d5f5;
            padding:8px 12px;font-size:13px;margin-bottom:10px;
        }
        textarea{resize:vertical;min-height:60px;}
        .btn{
            width:100%;padding:10px 0;border-radius:999px;border:none;
            background:linear-gradient(90deg,#1625b0,#2351e3);
            color:#fff;font-size:14px;font-weight:600;cursor:pointer;
            margin-top:4px;
        }
        .error{color:#e14848;font-size:12px;margin-bottom:6px;}
        .back{margin-top:10px;font-size:12px;}
        .back a{color:#1845c6;text-decoration:none;font-weight:500;}
    </style>
</head>
<body>

<div class="card">
    <div class="title">Create Room</div>
    <div class="subtitle">Give the room a name to start a joint savings.</div>

    <form method="POST" action="{{ route('group.create') }}">
    @csrf

    <input type="text" name="nama_room" placeholder="Enter room name"
           value="{{ old('nama_room') }}">

    <textarea name="deskripsi" placeholder="Description (optional)">{{ old('deskripsi') }}</textarea>

    <!-- Auto-generate kode room -->
    <input type="hidden" name="kode_room" value="{{ strtoupper(Str::random(6)) }}">

    <button type="submit" class="btn">Create Room</button>
</form>


    <div class="back">
        or <a href="{{ route('group.choose') }}">back to choose</a>
    </div>
</div>

</body>
</html>

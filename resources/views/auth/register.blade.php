<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Registrasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }

        body {
            background: #e6f6ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            width: 100%;
            max-width: 1000px;
            height: 560px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.12);
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            overflow: hidden;
        }

        /* LEFT */
        .left {
            background: linear-gradient(150deg, #111a78, #1845c6);
            color: #ffffff;
            padding: 40px 40px 40px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .left-top span {
            font-size: 13px;
            opacity: 0.8;
        }

        .left-title {
            margin-top: 40px;
            font-size: 28px;
            line-height: 1.3;
            font-weight: 700;
        }

        .left-bottom {
            font-size: 12px;
            opacity: 0.9;
        }

        .toggle-auth {
            margin-top: 24px;
        }

        .toggle-auth a,
        .toggle-auth span {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 16px;
            margin-right: 18px;
            cursor: pointer;
            opacity: 0.7;
            text-decoration: none;
        }

        .toggle-auth .active {
            font-weight: 600;
            opacity: 1;
            position: relative;
        }

        .toggle-auth .active::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 100%;
            height: 3px;
            border-radius: 999px;
            background: #ffda7b;
        }

        /* RIGHT */
        .right {
            padding: 40px 56px;
            background: #e4f7ff;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: #1845c6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: #163266;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .label {
            font-size: 13px;
            color: #4b5878;
            margin-bottom: 4px;
        }

        .input-row {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0;
            border-bottom: 1px solid #c8d7f0;
        }

        .input-row span {
            font-size: 18px;
        }

        .input-row input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding: 6px 0;
        }

        .policy {
            margin-top: 6px;
            font-size: 12px;
            color: #4b5878;
        }

        .policy a {
            color: #1845c6;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-register {
            width: 100%;
            margin-top: 18px;
            padding: 10px 0;
            border-radius: 999px;
            border: none;
            background: linear-gradient(90deg, #1625b0, #2351e3);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .bottom-text {
            text-align: center;
            font-size: 12px;
            color: #4b5878;
            margin-top: 14px;
        }

        .bottom-text a {
            color: #1845c6;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 900px) {
            .wrapper {
                max-width: 420px;
                grid-template-columns: 1fr;
                height: auto;
            }

            .left {
                display: none;
            }

            .right {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    {{-- LEFT SIDE --}}
    <div class="left">
        <div class="left-top">
            <span>Smart money starts here</span>
            <h1 class="left-title">
                Dream big, save smart,<br>
                and vibe with your goals<br>
                Join Poolin and start<br>
                your money journey today!
            </h1>
        </div>

        <div>
             
            <div class="left-bottom">
                Every big goal starts with a single coin.
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE (FORM) --}}
    <div class="right">
        <div class="logo">
            <div class="logo-icon">P</div>
            <div class="logo-text">Poolin</div>
        </div>

        {{-- sementara action-nya #, nanti diganti ke route register POST --}}
        <form method="POST" action="#">
            @csrf

            <div class="form-group">
                <div class="label">Username</div>
                <div class="input-row">
                    <span>👤</span>
                    <input type="text" name="username" placeholder="Enter your username">
                </div>
            </div>

            <div class="form-group">
                <div class="label">Email</div>
                <div class="input-row">
                    <span>✉️</span>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>
            </div>

            <div class="form-group">
                <div class="label">Password</div>
                <div class="input-row">
                    <span>🔒</span>
                    <input type="password" name="password" placeholder="Create a password">
                </div>
            </div>

            <div class="form-group">
                <div class="label">Confirm Password</div>
                <div class="input-row">
                    <span>🔑</span>
                    <input type="password" name="password_confirmation" placeholder="Repeat your password">
                </div>
            </div>

            <div class="policy">
                <label>
                    <input type="checkbox" name="agree">
                    I agree with <a href="#">privacy</a> and <a href="#">policy</a>
                </label>
            </div>

            <button type="submit" class="btn-register">
                Registrasi
            </button>

                        @if ($errors->any())
                <div>{{ $errors->first() }}</div>
            @endif

            @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif

            <div class="bottom-text">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>

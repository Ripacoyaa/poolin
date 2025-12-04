<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #e6f6ff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            width: 100%;
            max-width: 1000px;
            height: 560px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            box-shadow: 0 18px 40px rgba(0,0,0,0.12);
        }

        /* LEFT */
        .left {
            background: linear-gradient(150deg, #0f1979, #1d47c9);
            padding: 40px 48px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .left span {
            opacity: 0.8;
            font-size: 13px;
        }

        .left-title {
            margin-top: 40px;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.3;
        }

        .left-desc {
            margin-top: 10px;
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.5;
            max-width: 300px;
        }

        .left img {
            width: 180px;
            margin-top: 40px;
        }

        .left-bottom {
            font-size: 13px;
            opacity: 0.85;
            margin-top: 10px;
        }

        /* RIGHT */
        .right {
            background: #e4f7ff;
            padding: 40px 56px;
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
            background: #1d47c9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: #163266;
        }

        .right .title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #193463;
        }

        .right p {
            font-size: 14px;
            margin-bottom: 24px;
            color: #54627f;
        }

        .label {
            font-size: 13px;
            color: #4b5878;
            margin-bottom: 4px;
        }

        .input-row {
            border-bottom: 1px solid #c8d7f0;
            padding: 6px 0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .input-row input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            font-size: 14px;
        }

        .btn-primary {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(90deg, #1524b4, #2150e1);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .bottom-text {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #4b5878;
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
        <div>
            <span>🔐 Secure password recovery</span>

            <h1 class="left-title">Forgot your password?<br>No worries!</h1>

            <div class="left-desc">
                We’ll send you a reset link to get you back  
                on track with your savings journey.
            </div>
        </div>

        <div class="left-bottom">
            Your security is our priority.
        </div>
    </div>

    {{-- RIGHT SIDE --}}
    <div class="right">
        <div class="logo">
            <div class="logo-icon">P</div>
            <div class="logo-text">Poolin</div>
        </div>

        <h2 class="title">Reset Password</h2>
        <p>Enter your email and we’ll send you a link to reset your password</p>

        <form method="POST" action="#">
            @csrf

            <div class="label">Email</div>
            <div class="input-row">
                <span>✉️</span>
                <input type="email" name="email" placeholder="Enter your email">
            </div>

            <button type="submit" class="btn-primary">Send Reset Link</button>

            <div class="bottom-text">
                Remember your password?
                <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>

</div>

</body>
</html>

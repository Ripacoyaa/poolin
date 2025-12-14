<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Poolin - Login</title>

  <!-- Optional: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg: #e6f6ff;
      --right-bg: #dff4ff;
      --left-1: #111a78;
      --left-2: #1845c6;
      --text-dark: #163266;
      --muted: #6b7aa1;
      --line: #c8d7f0;
      --brand: #1845c6;
      --shadow: 0 18px 40px rgba(0,0,0,0.12);
      --radius: 24px;
    }

    *{ box-sizing:border-box; margin:0; padding:0; font-family:"Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }

    body{
      background: var(--bg);
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 24px;
    }

    .wrapper{
      width:100%;
      max-width: 1000px;
      min-height: 560px;
      background:#fff;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow:hidden;
      display:grid;
      grid-template-columns: 1.1fr 1fr;
      position:relative;
    }

    /* LEFT PANEL */
    .left{
      background: linear-gradient(150deg, var(--left-1), var(--left-2));
      color:#fff;
      padding: 36px 40px 28px 44px;
      display:flex;
      flex-direction:column;
      gap: 18px;
      position:relative;
    }

    .left .topline{
      display:flex;
      align-items:center;
      gap:10px;
      font-size:13px;
      opacity:.85;
      user-select:none;
    }

    .back{
      width:28px;
      height:28px;
      border-radius:999px;
      display:grid;
      place-items:center;
      border: 1px solid rgba(255,255,255,.25);
      background: rgba(255,255,255,.08);
    }

    .left h1{
      margin-top: 10px;
      font-size: 30px;
      line-height: 1.25;
      font-weight: 700;
      letter-spacing: .2px;
    }

    .left .illustration{
      flex:1;
      display:flex;
      align-items:flex-end;
      justify-content:center;
      padding: 10px 0 0;
    }

    .left .illustration img{
      width: min(330px, 100%);
      height:auto;
      display:block;
      filter: drop-shadow(0 18px 30px rgba(0,0,0,.18));
    }

    .left .footer{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap: 16px;
    }

    .left .caption{
      font-size:12px;
      opacity:.9;
      font-weight:500;
    }

    /* Toggle (Login / Registrasi) — dibuat kayak “notch” */
    .toggle{
      position:absolute;
      right: -56px;
      top: 250px;
      width: 112px;
      padding: 14px 10px;
      border-radius: 999px;
      background: #eaf7ff;
      box-shadow: 0 10px 24px rgba(0,0,0,.12);
      display:flex;
      flex-direction:column;
      gap: 12px;
      align-items:center;
      justify-content:center;
    }

    .toggle a{
      text-decoration:none;
      font-weight:600;
      font-size:16px;
      color: var(--text-dark);
      opacity:.7;
    }
    .toggle a.active{
      opacity:1;
    }

    /* RIGHT PANEL */
    .right{
      background: var(--right-bg);
      padding: 40px 56px;
      position:relative;
    }

    .logo{
      display:flex;
      align-items:center;
      gap: 10px;
      margin-bottom: 32px;
    }
    .logo-icon{
      width: 42px;
      height: 42px;
      border-radius: 14px;
      background: var(--brand);
      color:#fff;
      display:grid;
      place-items:center;
      font-weight:800;
      letter-spacing:.5px;
    }
    .logo-text{
      font-size: 28px;
      font-weight: 800;
      color: var(--text-dark);
      line-height:1;
    }

    form{ width:100%; }

    .form-group{ margin-bottom: 18px; }
    .label{
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 6px;
      font-weight:500;
    }

    .input-row{
      display:flex;
      align-items:center;
      gap: 10px;
      padding: 8px 0;
      border-bottom: 1px solid var(--line);
    }
    .input-icon{
      width: 22px;
      display:grid;
      place-items:center;
      color: var(--brand);
      font-size: 18px;
    }
    .input-row input{
      border:none;
      outline:none;
      background:transparent;
      flex:1;
      padding: 6px 0;
      font-size: 14px;
      color: #23304f;
    }
    .input-row input::placeholder{ color:#93a3c6; }

    .options{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      margin-top: 6px;
      font-size: 12px;
      color: var(--muted);
    }
    .options label{
      display:flex;
      align-items:center;
      gap: 8px;
      user-select:none;
    }
    .options a{
      color: var(--brand);
      text-decoration:none;
      font-weight:600;
    }

    .btn-login{
      width:100%;
      margin-top: 18px;
      padding: 12px 0;
      border:none;
      border-radius: 999px;
      cursor:pointer;
      color:#fff;
      font-size: 15px;
      font-weight: 700;
      background: linear-gradient(90deg, #1625b0, #2351e3);
      box-shadow: 0 10px 22px rgba(24,69,198,.25);
      transition: transform .12s ease, filter .12s ease;
    }
    .btn-login:active{ transform: scale(.99); }
    .btn-login:hover{ filter: brightness(1.03); }

    .error{
      margin-top: 12px;
      padding: 10px 12px;
      border-radius: 12px;
      background: rgba(255, 0, 0, 0.08);
      color: #8a1f1f;
      font-size: 13px;
      font-weight: 500;
    }

    .or-line{
      display:flex;
      align-items:center;
      gap: 10px;
      margin: 18px 0 14px;
      font-size: 12px;
      color: #7a8bb1;
      user-select:none;
    }
    .or-line .line{
      flex:1;
      height:1px;
      background: var(--line);
    }

    .socials{
      display:flex;
      justify-content:center;
      gap: 14px;
      margin-bottom: 14px;
    }
    .social-btn{
      width: 44px;
      height: 44px;
      border-radius: 999px;
      border:none;
      background:#fff;
      cursor:pointer;
      box-shadow: 0 6px 14px rgba(0,0,0,.10);
      display:grid;
      place-items:center;
      font-weight:800;
      color:#23304f;
    }

    .bottom-text{
      text-align:center;
      font-size: 12px;
      color: var(--muted);
    }
    .bottom-text a{
      color: var(--brand);
      text-decoration:none;
      font-weight:700;
    }

    /* Responsive */
    @media (max-width: 900px){
      .wrapper{
        max-width: 440px;
        grid-template-columns: 1fr;
        min-height:auto;
      }
      .left{ display:none; }
      .right{ padding: 32px 24px; }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- LEFT -->
    <aside class="left">
      <div class="topline">
        <div class="back">←</div>
        <span>Track your cash, grow your stash</span>
      </div>

      <h1>
        Let’s make saving a<br>
        whole vibe 💸<br>
        Welcome back,<br>
        smart spender 👋
      </h1>

      <div class="illustration">
        <!-- Ganti src sesuai asset kamu -->
        <img src="https://dummyimage.com/420x300/1f43c6/ffffff&text=Illustration" alt="Illustration">
      </div>

      <div class="footer">
        <div class="caption">Keep building your goals, one coin at a time.</div>
      </div>

      <!-- Toggle notch -->
      <div class="toggle">
        <a class="active" href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Registrasi</a>
      </div>
    </aside>

    <!-- RIGHT -->
    <main class="right">
      <div class="logo">
        <div class="logo-icon">P</div>
        <div class="logo-text">Poolin</div>
      </div>

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
          <div class="label">Email</div>
          <div class="input-row">
            <div class="input-icon">👤</div>
            <input type="email" name="email" placeholder="Enter your email" required>
          </div>
        </div>

        <div class="form-group">
          <div class="label">Password</div>
          <div class="input-row">
            <div class="input-icon">🔒</div>
            <input type="password" name="password" placeholder="Enter your password" required>
          </div>
        </div>

        <div class="options">
          <label>
            <input type="checkbox" name="remember">
            Remember me
          </label>
          <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit" class="btn-login">Login</button>

        @if ($errors->any())
          <div class="error">{{ $errors->first() }}</div>
        @endif

        <div class="or-line">
          <span class="line"></span>
          <span>or</span>
          <span class="line"></span>
        </div>

        <div class="socials">
          <button type="button" class="social-btn" aria-label="Login with Facebook">f</button>
          <button type="button" class="social-btn" aria-label="Login with Google">G</button>
        </div>

        <div class="bottom-text">
          Don’t have an account?
          <a href="{{ route('register') }}">Create Account</a>
        </div>
      </form>
    </main>
  </div>
</body>
</html>

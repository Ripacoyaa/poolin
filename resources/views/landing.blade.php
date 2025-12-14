<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poolin - Landing Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            background: linear-gradient(135deg, #03045E, #0608C4);
            color: #ffffff;
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 80px;
        }

        .navbar-logo {
            font-size: 26px;
            font-weight: 700;
        }

        .navbar-menu {
            display: flex;
            gap: 32px;
            font-size: 16px;
        }

        .navbar-menu a {
            text-decoration: none;
            color: #e5ecff;
        }

        .navbar-menu a:hover {
            color: #ffffff;
        }
        .login-btn {
    padding: 12px 28px;        /* bikin gede */
    border-radius: 999px;
    font-size: 24px;           /* teks lebih besar */
    font-weight: 700;          /* tebel */
    background: rgba(255,255,255,0.12);
    color: #ffffff;
    transition: all 0.2s ease;
}

.login-btn:hover {
    background: #CFF1F9;
    color: #03045E;
}

        /* HERO */
        .hero {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            padding: 40px 80px 20px;
            gap: 40px;
            align-items: center;
        }

        .hero-left h1 {
    font-size: 64px;        /* lebih gede */
    line-height: 1.15;
    margin-bottom: 18px;
    margin-top: -32px;     /* naik ke atas */
    font-weight: 750;

        }

        .hero-left p {
            font-size: 16px;
            line-height: 1.5;
            max-width: 480px;
            margin-bottom: 24px;
            color: #dbe6ff;
        }

        .btn-primary {
            display: inline-block;
            padding: 12px 32px;
            border-radius: 999px;
            border: none;
            background: #CFF1F9;
            color: #03045E;
            font-weight: 600;
            font-size: 32px;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0,0,0,0.25);
        }

        .btn-primary:hover {
            filter: brightness(0.96);
        }

        .hero-illustration {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-illustration img {
            width: 100%;
            max-width: 420px;
            height: auto;
        }

        /* FEATURES */
        .features-section {
            background: #CFF1F9;
            margin-top: 0px;
            border-radius: 40px 40px 0 0;
            padding: 32px 80px 48px;
            color: #253149;
        }

        .feature-cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            margin-top: -16px;
        }

        .feature-card {
            background: #CFF1F9;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(18, 84, 149, 0.25);
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 8px;
        }

        .feature-text {
            font-size: 14px;
            color: #41526c;
            line-height: 1.5;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .navbar {
                padding: 16px 24px;
            }

            .hero {
                padding: 24px;
                grid-template-columns: 1fr;
            }

            .hero-illustration {
                order: -1;
            }

            .features-section {
                padding: 40px 24px 48px;
            }

            .feature-cards {
                grid-template-columns: 1fr;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
<div class="page">

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="navbar-logo" style="margin-top: 12px;">
    <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" style="width: 200px; height: auto;">
</div>
       <nav class="navbar-menu">
    <a href="{{ route('login') }}" class="login-btn">Login</a>
</nav>
    </header>

    <!-- HERO -->
    <main id="home" class="hero">
        <section class="hero-left">
            <h1>Saving Together,<br>Growing Stronger.</h1>
            <p>
                Manage your personal or group savings with ease.
                Poolin helps you record, organize, and track every goal
                in one simple place.
            </p>
            <button class="btn-primary" onclick="window.location='{{ route('register') }}'">
                Registrasi
            </button>
        </section>

        <section class="hero-illustration">
                <img src="{{ asset('images/uang.png') }}" alt="Money Illustration" style="width: 70%; height: auto;">
        </section>
    </main>

    <!-- FEATURES -->
    <section id="features" class="features-section">
        <div class="feature-cards">

            <!-- CARD 1 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="40" height="40" viewBox="0 0 66 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32.7812 1.5C15.5332 1.5 1.5 15.5332 1.5 32.7812C1.5 50.0293 15.5332 64.0625 32.7812 64.0625C50.0293 64.0625 64.0625 50.0293 64.0625 32.7812C64.0625 15.5332 50.0293 1.5 32.7812 1.5ZM32.7812 6.3125C47.4281 6.3125 59.25 18.1344 59.25 32.7812C59.25 47.4281 47.4281 59.25 32.7812 59.25C18.1344 59.25 6.3125 47.4281 6.3125 32.7812C6.3125 18.1344 18.1344 6.3125 32.7812 6.3125ZM30.375 18.3438V30.375H18.3438V35.1875H30.375V47.2188H35.1875V35.1875H47.2188V30.375H35.1875V18.3438H30.375Z" fill="black" stroke="black" stroke-width="3"/>
                    </svg>
                </div>
                <h3 class="feature-title">Personal Savings</h3>
                <p class="feature-text">
                    Manage your own saving goals easily. Track your deposits and
                    achievements, all in one place.
                </p>
            </div>

            <!-- CARD 2 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="40" height="40" viewBox="0 0 66 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32.7812 1.5C15.5332 1.5 1.5 15.5332 1.5 32.7812C1.5 50.0293 15.5332 64.0625 32.7812 64.0625C50.0293 64.0625 64.0625 50.0293 64.0625 32.7812C64.0625 15.5332 50.0293 1.5 32.7812 1.5ZM32.7812 6.3125C47.4281 6.3125 59.25 18.1344 59.25 32.7812C59.25 47.4281 47.4281 59.25 32.7812 59.25C18.1344 59.25 6.3125 47.4281 6.3125 32.7812C6.3125 18.1344 18.1344 6.3125 32.7812 6.3125ZM30.375 18.3438V30.375H18.3438V35.1875H30.375V47.2188H35.1875V35.1875H47.2188V30.375H35.1875V18.3438H30.375Z" fill="black" stroke="black" stroke-width="3"/>
                    </svg>
                </div>
                <h3 class="feature-title">Group Savings</h3>
                <p class="feature-text">
                    Create or join a shared saving room with friends or family.
                    Save together, stay transparent, and reach goals faster.
                </p>
            </div>

            <!-- CARD 3 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="40" height="40" viewBox="0 0 66 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32.7812 1.5C15.5332 1.5 1.5 15.5332 1.5 32.7812C1.5 50.0293 15.5332 64.0625 32.7812 64.0625C50.0293 64.0625 64.0625 50.0293 64.0625 32.7812C64.0625 15.5332 50.0293 1.5 32.7812 1.5ZM32.7812 6.3125C47.4281 6.3125 59.25 18.1344 59.25 32.7812C59.25 47.4281 47.4281 59.25 32.7812 59.25C18.1344 59.25 6.3125 47.4281 6.3125 32.7812C6.3125 18.1344 18.1344 6.3125 32.7812 6.3125ZM30.375 18.3438V30.375H18.3438V35.1875H30.375V47.2188H35.1875V35.1875H47.2188V30.375H35.1875V18.3438H30.375Z" fill="black" stroke="black" stroke-width="3"/>
                    </svg>
                </div>
                <h3 class="feature-title">Track Progress</h3>
                <p class="feature-text">
                    See how your savings grow over time. Monitor every goal with
                    simple, visual tracking tools.
                </p>
            </div>

        </div>
    </section>

</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Poolin - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            dark: '#03045E',
            mid: '#023E8A',
            light: '#CFF1F9',
            g1: '#050691',
            g2: '#0608C4',
          }
        }
      }
    }
  </script>
</head>

<body class="min-h-screen flex font-sans bg-light">

  <!-- LEFT PANEL -->
  <div class="hidden md:flex md:w-1/2 bg-gradient-to-b from-g1 to-g2 text-white p-16 flex-col justify-between">
    <div>
      <p class="text-sm opacity-80 mb-6">
        Track your cash, grow your stash
      </p>
      <h1 class="text-3xl font-bold leading-snug">
        Let’s make saving a <br>
        whole vibe 💸 <br>
        Welcome back, <br>
        smart spender 👋
      </h1>
    </div>

    <div class="flex justify-center">
      <img src="{{ asset('images/LoginPage.png') }}" alt="Login Illustration" class="w-60">
    </div>

    <p class="text-sm opacity-80">
      Keep building your goals, one coin at a time.
    </p>
  </div>

  <!-- RIGHT PANEL -->
  <div class="w-full md:w-1/2 bg-light flex items-center justify-center">
  <div class="w-[420px] p-8 flex flex-col items-center">


      <!-- LOGO -->
      <div class="mb-10 mt-2">
  <img 
    src="{{ asset('images/logoPoolinGelap.png') }}" 
    alt="Poolin" 
    class="w-52 mx-auto"
  >
</div>

      <!-- FORM LOGIN (Laravel) -->
      <form method="POST" action="{{ route('login.post') }}" class="space-y-6 w-full">
        @csrf

        <!-- EMAIL -->
        <div class="flex items-center gap-3 border-b-2 border-dark py-2">
          <img src="{{ asset('images/logoUser.png') }}" class="w-5 h-5 opacity-70" alt="user">
          <input
            name="email"
            type="email"
            required
            placeholder="Email"
            value="{{ old('email') }}"
            class="flex-1 bg-transparent outline-none"
          >
        </div>

        <!-- PASSWORD -->
        <div class="flex items-center gap-3 border-b-2 border-dark py-2">
          <img src="{{ asset('images/padlock.png') }}" class="w-5 h-5 opacity-70" alt="lock">

          <input
            id="password"
            name="password"
            type="password"
            required
            placeholder="Password"
            class="flex-1 bg-transparent outline-none"
          >

          <button type="button" onclick="togglePassword()" class="shrink-0">
            <img id="toggleIcon" src="{{ asset('images/hidden.png') }}" class="w-5 h-5 opacity-80" alt="toggle">
          </button>
        </div>

        <!-- ERROR MESSAGE (Laravel validation/auth errors) -->
        @if ($errors->any())
          <p class="text-red-600 text-sm">
            {{ $errors->first() }}
          </p>
        @endif

        <!-- OPTIONS -->
        <div class="flex justify-between text-sm text-dark">
          <label class="flex items-center gap-2">
            <input type="checkbox" name="remember" class="accent-dark">
            Remember me
          </label>

          @if (Route::has('password.request')) 
            <a href="{{ route('password.request') }}" class="hover:underline">
              Forgot password?
            </a>
          @else
            <a href="#" class="hover:underline">
              Forgot password?
            </a>
          @endif
        </div>

        <!-- LOGIN BUTTON -->
        <button type="submit"
          class="w-full bg-gradient-to-b from-g1 to-g2 text-white py-3 rounded-full font-semibold">
          Login
        </button>

        <!-- REGISTER LINK -->
        <p class="text-center text-sm text-dark">
          Don’t have an account?
          <a href="{{ route('register') }}" class="font-semibold underline">
            Create Account
          </a>
        </p>
      </form>

    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      const icon = document.getElementById("toggleIcon");

      if (input.type === "password") {
        input.type = "text";
        icon.src = "{{ asset('images/eye.png') }}";
      } else {
        input.type = "password";
        icon.src = "{{ asset('images/hidden.png') }}";
      }
    }
  </script>

</body>
</html>

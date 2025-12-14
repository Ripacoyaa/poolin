<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Poolin - Registrasi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Optional: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ["Poppins", "ui-sans-serif", "system-ui"] },
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

  <style>
    body { background-color:#CFF1F9; }
  </style>
</head>

<body class="min-h-screen flex font-sans">

  <!-- LEFT PANEL -->
  <aside class="hidden md:flex w-1/2 bg-gradient-to-b from-g1 to-g2 text-white p-16 flex-col justify-between">
    <div>
      <p class="text-sm opacity-80 mb-6">
        Smart money starts here
      </p>
      <h1 class="text-3xl font-bold leading-snug">
        Dream big, save smart,<br>
        and vibe with your goals<br>
        Join Poolin and start<br>
        your money journey today!
      </h1>
    </div>

    <div class="flex justify-center">
      {{-- ganti path asset sesuai folder public kamu --}}
      <img src="{{ asset('images/loginPage.png') }}" class="w-60" alt="Illustration">
    </div>

    <p class="text-sm opacity-80 italic">
      Every big goal starts with a single coin.
    </p>
  </aside>

  <!-- RIGHT PANEL -->
  <main class="w-full md:w-1/2 bg-light flex items-center justify-center px-6">
    <div class="w-full max-w-[420px] p-8">

      <!-- LOGO (tengah + agak turun dikit biar gak mepet) -->
      <div class="flex justify-center mb-10 mt-2">
        <img src="{{ asset('images/logoPoolinGelap.png') }}" class="w-52 h-auto" alt="Poolin Logo">
      </div>

      {{-- FLASH / ERROR GLOBAL --}}
      @if ($errors->any())
        <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg px-4 py-2">
          {{ $errors->first() }}
        </div>
      @endif
      @if (session('success'))
        <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-lg px-4 py-2">
          {{ session('success') }}
        </div>
      @endif

      <!-- FORM -->
      <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- NAME -->
        <div class="flex items-center gap-3 border-b-2 border-dark py-2">
          <img src="{{ asset('images/logoUser.png') }}" class="w-5 h-5 opacity-70" alt="">
          <input
            name="name"
            required
            placeholder="Username"
            class="flex-1 bg-transparent outline-none"
            value="{{ old('name') }}"
          >
        </div>
        @error('name')
          <p class="text-xs text-red-600 -mt-4">{{ $message }}</p>
        @enderror

        <!-- EMAIL (pakai mata) -->
        <div class="flex items-center gap-3 border-b-2 border-dark py-2">
          <img src="{{ asset('images/gmail.png') }}" class="w-5 h-5 opacity-70" alt="">

          <input
            id="emailInput"
            name="email"
            type="password"
            required
            placeholder="Email"
            class="flex-1 bg-transparent outline-none"
            value="{{ old('email') }}"
          >

          <button type="button" onclick="toggleEmail(this)" class="shrink-0">
            <img src="{{ asset('images/hidden.png') }}" class="w-5 h-5 opacity-80" alt="toggle email">
          </button>
        </div>
        @error('email')
          <p class="text-xs text-red-600 -mt-4">{{ $message }}</p>
        @enderror

        <!-- PASSWORD -->
        <div class="flex items-center gap-3 border-b-2 border-dark py-2">
          <img src="{{ asset('images/padlock.png') }}" class="w-5 h-5 opacity-70" alt="">

          <input
            id="password"
            name="password"
            type="password"
            required
            placeholder="Password"
            class="flex-1 bg-transparent outline-none"
          >

          <button type="button" onclick="togglePassword('password', this)" class="shrink-0">
            <img src="{{ asset('images/hidden.png') }}" class="w-5 h-5 opacity-80" alt="toggle password">
          </button>
        </div>
        @error('password')
          <p class="text-xs text-red-600 -mt-4">{{ $message }}</p>
        @enderror

        <!-- CONFIRM PASSWORD -->
        <div class="flex items-center gap-3 border-b-2 border-dark py-2">
          <img src="{{ asset('images/padlock1.png') }}" class="w-5 h-5 opacity-70" alt="">

          <input
            id="confirmPassword"
            name="password_confirmation"
            type="password"
            required
            placeholder="Confirm Password"
            class="flex-1 bg-transparent outline-none"
          >

          <button type="button" onclick="togglePassword('confirmPassword', this)" class="shrink-0">
            <img src="{{ asset('images/hidden.png') }}" class="w-5 h-5 opacity-80" alt="toggle confirm password">
          </button>
        </div>

        <!-- AGREEMENT -->
        <label class="flex items-center gap-2 text-sm text-dark">
          <input type="checkbox" name="agree" required class="accent-dark">
          I agree with privacy and policy
        </label>

        <!-- REGISTER BUTTON -->
        <button
          type="submit"
          class="w-full bg-gradient-to-b from-g1 to-g2 text-white py-3 rounded-full font-semibold hover:opacity-90 transition"
        >
          Registrasi
        </button>

        <p class="text-center text-sm text-dark">
          Already have an account?
          <a href="{{ route('login') }}" class="font-semibold underline">
            Login
          </a>
        </p>

      </form>
    </div>
  </main>

<script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector("img");

    if (input.type === "password") {
      input.type = "text";
      icon.src = "{{ asset('images/eye.png') }}";
    } else {
      input.type = "password";
      icon.src = "{{ asset('images/hidden.png') }}";
    }
  }

  function toggleEmail(btn) {
    const input = document.getElementById("emailInput");
    const icon = btn.querySelector("img");

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

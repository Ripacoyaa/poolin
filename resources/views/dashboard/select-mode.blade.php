<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome | Poolin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

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

<body class="min-h-screen flex flex-col text-white bg-gradient-to-br from-g1 to-g2">

  <!-- ========== HEADER ========== -->
  <header class="flex justify-between items-center px-10 py-6">
    <!-- LOGO -->
    <div class="flex items-center">
      {{-- pindahin file ke public/images --}}
      <img src="{{ asset('images/logoPoolin.png') }}" class="w-52 h-auto" alt="Poolin Logo">
    </div>

    <!-- Logout Laravel (POST) -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="button" onclick="confirmLogout()" class="font-semibold text-light hover:underline">
        Logout
      </button>
    </form>
  </header>

  <!-- ========== MAIN CONTENT ========== -->
  <main class="flex-1 flex flex-col items-center justify-center text-center px-6 -mt-20">

    <h1 class="text-4xl md:text-5xl font-bold mb-4">
  Welcome Back, <span class="text-white">{{ auth()->user()->name }}</span> 👋
</h1>


    <p class="text-lg font-semibold mb-1 text-white">
      Where do you want to go today ?
    </p>

    <p class="text-white mb-10">
      Choose your saving space to start managing your goals.
    </p>

    <!-- ========== OPTIONS ========== -->
    <div class="flex flex-col md:flex-row gap-8">

      <!-- PERSONAL SAVINGS -->
      <a href="{{ route('personal.home') }}"
         class="bg-light text-dark rounded-2xl p-8 w-72 shadow-xl hover:scale-105 transition text-center">

        <img
          src="{{ asset('images/logoPersonal.png') }}"
          alt="Personal Savings"
          class="w-20 h-20 mx-auto mb-4 object-contain"
        />

        <h2 class="text-xl font-bold mb-2 text-dark">
          Personal Savings
        </h2>

        <p class="text-sm text-mid">
          Manage your own saving goals easily. Track your deposits and achievements,
          all in one place.
        </p>
      </a>

      <!-- GROUP SAVINGS -->
      <a href="{{ route('group.home') }}"
         class="bg-light text-dark rounded-2xl p-8 w-72 shadow-xl hover:scale-105 transition text-center">

        <img
          src="{{ asset('images/logoGroup.png') }}"
          alt="Group Savings"
          class="w-20 h-20 mx-auto mb-4 object-contain"
        />

        <h2 class="text-xl font-bold mb-2 text-dark">
          Group Savings
        </h2>

        <p class="text-sm text-mid">
          Create or join a shared saving room with friends or family.
          Save together, stay transparent, and reach goals faster.
        </p>
      </a>

    </div>
  </main>

  <script>
    function confirmLogout() {
      const ok = confirm("Are you sure you want to log out?");
      if (ok) document.getElementById("logoutForm").submit();
    }
  </script>

</body>
</html>

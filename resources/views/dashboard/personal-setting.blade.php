<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - Poolin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="flex h-screen overflow-hidden bg-[#CFF1F9]">

  @php
    $defaultPhoto = asset('images/user.png');
    $photoUrl = auth()->user()->photo_path
      ? asset('storage/' . auth()->user()->photo_path)
      : $defaultPhoto;
  @endphp

  <!-- SIDEBAR -->
  <aside class="w-64 bg-gradient-to-b from-[#050691] to-[#0608C4] text-white p-6 flex flex-col">
    <div class="text-3xl font-bold mb-0 flex items-center gap-2">
      <img src="{{ asset('images/logoPoolin.png') }}" alt="Logo Poolin" style="width: 100%; height: auto;">
    </div>

    <nav class="space-y-2 mt-6">
      <a href="{{ route('personal.home') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold
                {{ request()->routeIs('personal.home') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A] hover:shadow-[0_6px_18px_rgba(0,0,0,0.35)]' }}">
        <img src="{{ asset('images/homePage.png') }}" alt="Home" style="width: 10%; height: auto;">
        <span>Home</span>
      </a>

      <a href="{{ route('personal.goals') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ request()->routeIs('personal.goals*') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
        <img src="{{ asset('images/savings.png') }}" alt="My Goals" style="width: 10%; height: auto;">
        <span>My Goals</span>
      </a>

      <a href="{{ route('personal.report') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ request()->routeIs('personal.report') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
        <img src="{{ asset('images/report.png') }}" alt="Report" style="width: 10%; height: auto;">
        <span>Report</span>
      </a>

      <a href="{{ route('personal.setting') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ request()->routeIs('personal.setting') ? 'bg-[#023E8A] shadow-[0_4px_12px_rgba(0,0,0,0.25)]' : 'hover:bg-[#023E8A]' }}">
        <img src="{{ asset('images/accountSetting.png') }}" alt="Account Setting" style="width: 10%; height: auto;">
        <span>Account Setting</span>
      </a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 p-5 overflow-y-auto">
    <div class="max-w-full mx-auto flex flex-col gap-6">

      <!-- LOGOUT BUTTON -->
      <div class="flex justify-end w-full">
        <button id="logoutBtn"
          class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
      </div>

      {{-- ALERT --}}
      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-xl text-sm">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-xl text-sm mb-2">
          <ul class="list-disc ml-5">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- PROFILE CARD -->
      <div class="bg-white shadow-lg rounded-2xl border border-blue-100 p-6 w-full">
        <div class="flex justify-between items-center w-full">
          <div class="flex items-center gap-4">
            <img
              src="{{ auth()->user()->photo_path ? \Illuminate\Support\Facades\Storage::url(auth()->user()->photo_path) : asset('images/user.png') }}"
              class="w-20 h-20 rounded-full object-cover shadow-md main-profile"
              alt="Profile">
            <div>
              <h2 class="text-2xl font-bold text-[#03045E]">
                {{ auth()->user()->name ?? 'User' }}
              </h2>
            </div>
          </div>

          <button id="openModal" type="button"
            class="px-6 py-2 bg-[#1A1A7E] text-white font-semibold rounded-xl hover:bg-[#0F0F6A] shadow">
            Change Photo Profile
          </button>
        </div>
      </div>

      <!-- FORM CARD -->
      <div class="bg-white shadow-lg rounded-2xl border border-blue-100 p-6 w-full">
        <h3 class="text-lg font-bold text-[#03045E] mb-4">
          Change account information here
        </h3>

        <form id="settingForm"
              class="space-y-4"
              method="POST"
              action="{{ route('personal.setting.update') }}"
              enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- ✅ SATU-SATUNYA INPUT FILE (HARUS DI DALAM FORM) -->
          <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden">
          <!-- opsional utk delete foto -->
          <input type="hidden" id="removePhoto" name="remove_photo" value="0">

          <!-- FULL NAME -->
          <div>
            <label class="font-semibold text-gray-700">Full Name</label>
            <input
              id="nameInput"
              type="text"
              name="name"
              value="{{ old('name', auth()->user()->name ?? '') }}"
              readonly
              class="w-full border rounded-xl p-3 mt-1 bg-gray-200 text-gray-600 cursor-not-allowed outline-none">
          </div>


          <!-- EMAIL -->
          <div>
            <label class="font-semibold text-gray-700">Email Address</label>
            <input
              id="emailInput"
              type="email"
              name="email"
              value="{{ old('email', auth()->user()->email ?? '') }}"
              readonly
              class="w-full border rounded-xl p-3 mt-1 bg-gray-200 text-gray-600 cursor-not-allowed outline-none">
          </div>

          <!-- PASSWORD SECTION (HIDDEN BY DEFAULT) -->
          <div id="passwordSection" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="font-semibold text-gray-700">Password</label>
              <div class="relative">
                <input
                  id="password"
                  name="password"
                  type="password"
                  class="w-full border rounded-xl p-3 mt-1 bg-[#F7FBFF] outline-none focus:ring-2 focus:ring-blue-300"
                  placeholder="New password">
                <i id="togglePassword"
                   class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"></i>
              </div>
            </div>

            <div>
              <label class="font-semibold text-gray-700">Confirm Password</label>
              <div class="relative">
                <input
                  id="confirmPassword"
                  name="password_confirmation"
                  type="password"
                  class="w-full border rounded-xl p-3 mt-1 bg-[#F7FBFF] outline-none focus:ring-2 focus:ring-blue-300"
                  placeholder="Confirm password">
                <i id="toggleConfirmPassword"
                   class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"></i>
              </div>
            </div>
          </div>

          <!-- BUTTONS -->
          <div class="mt-6 flex gap-4">
            <button id="updateBtn" type="button"
              class="w-full py-3 bg-[#03045E] text-white font-bold rounded-xl hover:bg-[#07089C] shadow">
              Update Information
            </button>

            <button id="saveBtnUI" type="button"
              class="hidden w-1/2 py-3 bg-[#03045E] text-white font-bold rounded-xl hover:bg-[#07089C] shadow">
              Save
            </button>

            <button id="cancelBtn" type="button"
              class="hidden w-1/2 py-3 bg-gray-300 text-gray-800 font-bold rounded-xl hover:bg-gray-400">
              Cancel
            </button>
          </div>

          <!-- REAL SUBMIT -->
          <button id="saveBtnReal" type="submit" class="hidden"></button>
        </form>
      </div>

      <!-- LOGOUT FORM -->
      <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
      </form>

    </div>
  </main>

  <!-- LOGOUT POPUP -->
  <div id="logoutPopup"
       class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white w-80 rounded-xl shadow-lg p-6 text-center">
      <h2 class="text-xl font-bold mb-3">Logout?</h2>
      <p class="text-gray-600 mb-5">Are you sure you want to logout?</p>

      <div class="flex justify-between gap-3">
        <button id="cancelLogout"
          class="flex-1 bg-gray-300 text-black py-2 rounded-xl hover:bg-gray-400 transition">
          Cancel
        </button>

        <button id="confirmLogout"
          class="flex-1 bg-red-600 text-white py-2 rounded-xl hover:bg-red-700 transition">
          Yes, Logout
        </button>
      </div>
    </div>
  </div>

  <!-- PHOTO MODAL -->
  <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white w-96 p-6 rounded-2xl shadow-xl relative">
      <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
        &times;
      </button>

      <h2 class="text-xl font-bold text-[#03045E] mb-4 text-center">Change Profile Photo</h2>

      <div class="flex justify-center mb-4">
        <img id="profilePreview"
             src="{{ auth()->user()->photo_path ? \Illuminate\Support\Facades\Storage::url(auth()->user()->photo_path) : asset('images/user.png') }}"
             class="w-32 h-32 rounded-full object-cover shadow-md border"
             alt="Preview">
      </div>

      <!-- ✅ TIDAK ADA INPUT FILE DI MODAL -->
      <button id="choosePhotoBtn" type="button"
        class="block w-full bg-[#03045E] text-white py-2 rounded-xl text-center cursor-pointer hover:bg-[#0507A0] mb-3">
        Upload New Photo
      </button>

      <button id="deletePhoto" type="button"
        class="w-full py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 mb-3">
        Delete Photo
      </button>

      <div class="flex justify-center mt-4 gap-3">
        <button id="savePhotoBtn" type="button" class="bg-blue-600 text-white px-4 py-2 rounded-xl">
          Save
        </button>
        <button id="cancelPhotoBtn" type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl">
          Cancel
        </button>
      </div>
    </div>
  </div>

<script>
  // --- Helper to safely get elements ---
  const $ = id => document.getElementById(id);

  // LOGOUT
  const logoutBtn = $('logoutBtn');
  const logoutPopup = $('logoutPopup');
  const cancelLogout = $('cancelLogout');
  const confirmLogout = $('confirmLogout');
  const logoutForm = $('logout-form');

  logoutBtn?.addEventListener('click', () => logoutPopup.classList.remove('hidden'));
  cancelLogout?.addEventListener('click', () => logoutPopup.classList.add('hidden'));
  confirmLogout?.addEventListener('click', () => logoutForm?.submit());

  // EDIT MODE
  const updateBtn = $('updateBtn');
  const saveBtnUI = $('saveBtnUI');
  const cancelBtn = $('cancelBtn');
  const saveBtnReal = $('saveBtnReal');

  const passwordSection = $('passwordSection');

  const nameInput = $('nameInput');
  const usernameInput = $('usernameInput');
  const emailInput = $('emailInput');

  const inputs = [nameInput, usernameInput, emailInput];

  const initialValues = {};
  inputs.forEach(i => { if (i) initialValues[i.id] = i.value; });

  function setEditMode(isEdit) {
    inputs.forEach(input => {
      if (!input) return;
      input.readOnly = !isEdit;

      if (isEdit) {
        input.classList.remove("bg-gray-200", "text-gray-600", "cursor-not-allowed");
        input.classList.add("bg-[#F7FBFF]");
      } else {
        input.classList.add("bg-gray-200", "text-gray-600", "cursor-not-allowed");
        input.classList.remove("bg-[#F7FBFF]");
      }
    });

    if (passwordSection) passwordSection.classList.toggle("hidden", !isEdit);

    if (updateBtn) updateBtn.classList.toggle("hidden", isEdit);
    if (saveBtnUI) saveBtnUI.classList.toggle("hidden", !isEdit);
    if (cancelBtn) cancelBtn.classList.toggle("hidden", !isEdit);
  }

  updateBtn?.addEventListener('click', () => {
    setEditMode(true);
    nameInput?.focus();
  });

  cancelBtn?.addEventListener('click', () => {
    inputs.forEach(i => { if (i) i.value = initialValues[i.id] ?? ''; });
    const p = $('password'); const c = $('confirmPassword');
    if (p) p.value = '';
    if (c) c.value = '';
    setEditMode(false);
  });

  saveBtnUI?.addEventListener('click', () => saveBtnReal?.click());
  setEditMode(false);

  // eye toggle (safe)
  $('togglePassword')?.addEventListener('click', () => {
    const p = $('password'); if (!p) return;
    p.type = p.type === 'password' ? 'text' : 'password';
  });
  $('toggleConfirmPassword')?.addEventListener('click', () => {
    const p = $('confirmPassword'); if (!p) return;
    p.type = p.type === 'password' ? 'text' : 'password';
  });

  // PHOTO MODAL & UPLOAD
  const openModal = $('openModal');
  const closeModal = $('closeModal');
  const modal = $('photoModal');

  const choosePhotoBtn = $('choosePhotoBtn');
  const deletePhotoBtn = $('deletePhoto');
  const savePhotoBtn = $('savePhotoBtn');
  const cancelPhotoBtn = $('cancelPhotoBtn');

  const photoInput = $('photoInput'); // the actual input inside the form
  const removePhoto = $('removePhoto');

  const preview = $('profilePreview');
  const mainProfileImg = document.querySelector('.main-profile');

  // keep originals to revert on cancel
  const originalMainSrc = mainProfileImg ? mainProfileImg.getAttribute('src') : '';
  const originalPreviewSrc = preview ? preview.getAttribute('src') : '';

  openModal?.addEventListener('click', () => modal.classList.remove('hidden'));
  closeModal?.addEventListener('click', () => modal.classList.add('hidden'));

  cancelPhotoBtn?.addEventListener('click', () => {
    if (preview) preview.src = originalPreviewSrc;
    if (mainProfileImg) mainProfileImg.src = originalMainSrc;
    modal.classList.add('hidden');
  });

  // close modal when clicking backdrop
  modal?.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });

  // open file picker
  choosePhotoBtn?.addEventListener('click', () => photoInput?.click());

  // when user selects a file, update preview and main image
  photoInput?.addEventListener('change', (e) => {
    const file = e.target.files && e.target.files[0];
    if (!file) return;
    if (removePhoto) removePhoto.value = "0";
    const url = URL.createObjectURL(file);
    if (preview) preview.src = url;
    if (mainProfileImg) mainProfileImg.src = url;
  });

  // delete photo -> set remove flag, clear file input, show default
  deletePhotoBtn?.addEventListener('click', () => {
    if (removePhoto) removePhoto.value = "1";
    if (photoInput) photoInput.value = "";
    if (preview) preview.src = "{{ $defaultPhoto }}";
    if (mainProfileImg) mainProfileImg.src = "{{ $defaultPhoto }}";
  });

  // save photo from modal -> if there's a file selected or user requested removal, submit the form
  savePhotoBtn?.addEventListener('click', () => {
    const hasFile = photoInput && photoInput.files && photoInput.files.length > 0;
    const wantsRemove = removePhoto && removePhoto.value === "1";
    modal.classList.add('hidden');

    if (hasFile || wantsRemove) {
      // submit the main form so backend handles file upload / removal
      saveBtnReal?.click();
    }
  });
</script>

</body>
</html>

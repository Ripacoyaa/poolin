<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalGoalController;
use App\Http\Controllers\PersonalReportController;
use App\Http\Controllers\GroupRoomController;
use App\Http\Controllers\GroupHomeController;
use App\Http\Controllers\GroupDashboardController;

// landing
Route::get('/', function () {
    return view('landing');
});

// halaman auth (view)
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot')->name('password.request');

// proses auth
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// setelah login, pilih mode dulu
Route::get('/select-mode', function () {
    return view('dashboard.select-mode');
})->middleware('auth')->name('select-mode');

// nanti ini buat personal & group (sementara placeholder dulu)
Route::get('/personal', function () {
    return view('dashboard.personal');
})->middleware('auth')->name('personal.home');

Route::get('/group/choose', function () {
    return view('dashboard.group-choose');
})->middleware('auth')->name('group.choose');

Route::get('/personal/goals', function () {
    return view('dashboard.goals');
})->middleware('auth')->name('personal.goals');

Route::prefix('personal')->middleware('auth')->group(function () {
Route::get('/goals', [PersonalGoalController::class, 'index'])->name('personal.goals');
Route::get('/goals/create', [PersonalGoalController::class, 'create'])->name('personal.goals.create');
Route::post('/goals', [PersonalGoalController::class, 'store'])->name('personal.goals.store');
Route::get('/goals/{goal}/edit', [PersonalGoalController::class, 'edit'])->name('personal.goals.edit');
Route::put('/goals/{goal}', [PersonalGoalController::class, 'update'])->name('personal.goals.update');
Route::delete('/goals/{goal}', [PersonalGoalController::class, 'destroy'])->name('personal.goals.destroy');
Route::get('/goals/{goal}/save', [PersonalGoalController::class, 'saveForm'])->name('personal.goals.save');
Route::post('/goals/{goal}/save', [PersonalGoalController::class, 'saveStore'])->name('personal.goals.save.store');
});

Route::prefix('personal')->middleware('auth')->group(function () {
    // ... route goals yang sudah ada

Route::get('/report', [PersonalReportController::class, 'index'])
        ->name('personal.report');
});

Route::get('/personal/setting', function () {
    return view('dashboard.personal-setting');
})->middleware('auth')->name('personal.setting');

Route::middleware('auth')->group(function () {

    // ... route personal kamu

    // GROUP MODE
    Route::get('/group/choose', [GroupRoomController::class, 'choose'])
        ->name('group.choose');

    Route::get('/group/create', [GroupRoomController::class, 'createForm'])
        ->name('group.create.form');
    Route::post('/group/create', [GroupRoomController::class, 'store'])
        ->name('group.create.store');

    Route::get('/group/join', [GroupRoomController::class, 'joinForm'])
        ->name('group.join.form');
    Route::post('/group/join', [GroupRoomController::class, 'join'])
        ->name('group.join.store');

    Route::get('/group/created/{room}', [GroupRoomController::class, 'created'])
        ->name('group.created');

    Route::get('/group/room/{room}', [GroupRoomController::class, 'room'])
        ->name('group.room');
});

// home semua group user
Route::get('/group/home', [GroupHomeController::class, 'index'])
    ->middleware('auth')
    ->name('group.home');

// form create & join boleh tetap yang lama
Route::get('/group/create', [GroupRoomController::class, 'createForm'])
    ->middleware('auth')
    ->name('group.create');

Route::post('/group/create', [GroupRoomController::class, 'store'])
    ->middleware('auth')
    ->name('group.store');

Route::get('/group/join', [GroupRoomController::class, 'joinForm'])
    ->middleware('auth')
    ->name('group.join');

Route::post('/group/join', [GroupRoomController::class, 'join'])
    ->middleware('auth')
    ->name('group.join.post');

// dashboard per room
Route::get('/group/room/{room}', [GroupRoomController::class, 'show'])
    ->middleware('auth')
    ->name('group.room.show');
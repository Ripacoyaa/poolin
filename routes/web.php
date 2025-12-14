<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalGoalController;
use App\Http\Controllers\PersonalReportController;
use App\Http\Controllers\PersonalDashboardController;
use App\Http\Controllers\GroupRoomController;
use App\Http\Controllers\GroupHomeController;
use App\Http\Controllers\GroupDashboardController;
use App\Http\Controllers\GroupContributionController;

/*
|--------------------------------------------------------------------------
| Landing & Auth
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Select Mode setelah login
|--------------------------------------------------------------------------
*/
Route::get('/select-mode', function () {
    return view('dashboard.select-mode');
})->middleware('auth')->name('select-mode');

/*
|--------------------------------------------------------------------------
| PERSONAL MODE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('personal')->name('personal.')->group(function () {

    Route::get('/', [PersonalDashboardController::class, 'index'])->name('home');


    // goals
    Route::get('/goals', [PersonalGoalController::class, 'index'])->name('goals');
    Route::get('/goals/create', [PersonalGoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [PersonalGoalController::class, 'store'])->name('goals.store');
    Route::get('/goals/{goal}/edit', [PersonalGoalController::class, 'edit'])->name('goals.edit');
    Route::put('/goals/{goal}', [PersonalGoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{goal}', [PersonalGoalController::class, 'destroy'])->name('goals.destroy');

    // save now
    Route::get('/goals/{goal}/save', [PersonalGoalController::class, 'saveForm'])->name('goals.save');
    Route::post('/goals/{goal}/save', [PersonalGoalController::class, 'saveStore'])->name('goals.save.store');

    // report
    Route::get('/report', [PersonalReportController::class, 'index'])->name('report');

    // setting
    Route::get('/setting', function () {
        return view('dashboard.personal-setting');
    })->name('setting');

    // ✅ setting update (tangkap submit form)
    Route::put('/setting', [AuthController::class, 'updateProfile'])
        ->name('setting.update');
});

/*
|--------------------------------------------------------------------------
| GROUP MODE
|--------------------------------------------------------------------------*/
Route::middleware('auth')->prefix('group')->name('group.')->group(function () {

    // Home
    Route::get('/home', [GroupHomeController::class, 'index'])->name('home');

    // Rooms
    Route::get('/rooms', [GroupRoomController::class, 'index'])->name('rooms');
    Route::get('/rooms/{room}', [GroupRoomController::class, 'show'])->name('rooms.show');
    Route::get('/rooms/{room}/edit', [GroupRoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [GroupRoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [GroupRoomController::class, 'destroy'])->name('rooms.destroy');
    Route::post('/rooms/{room}/spend', [GroupRoomController::class, 'storeSpend'])->name('rooms.spend');


    // Create room
    Route::get('/create', [GroupRoomController::class, 'create'])->name('create');
    Route::post('/create', [GroupRoomController::class, 'store'])->name('create.store');

    // Join room
    Route::get('/join', [GroupRoomController::class, 'join'])->name('join');
    Route::post('/join', [GroupRoomController::class, 'join'])->name('join.store');

    // Created page
    Route::get('/created/{room}', [GroupRoomController::class, 'created'])->name('created');

    // Setting
    Route::get('/setting', fn () => view('group.setting'))->name('setting');

    // Contributions list
    Route::get('/contributions', [GroupContributionController::class, 'index'])->name('contributions');

    // Transaction page (GET)
// Contributions
Route::get('/contributions', [GroupContributionController::class, 'index'])->name('contributions');
Route::get('/contributions/{room}/transaction', [GroupContributionController::class, 'transaction'])->name('transaction');

Route::post('/contributions/{room}/spend', [GroupContributionController::class, 'storeSpend'])->name('contributions.spend');
Route::post('/contributions/{room}/withdraw', [GroupContributionController::class, 'storeWithdraw'])->name('contributions.withdraw');

});

use App\Models\Room;

Route::get('/debug-room/{id}', function ($id) {
    $room = Room::with('tabungan')->findOrFail($id);

    return response()->json([
        'room_id' => $room->id,
        'room_user_id(tabungan)' => $room->user_id,
        'tabungan' => $room->tabungan->map(fn($t) => [
            'id' => $t->id,
            'user_id' => $t->user_id,
            'room_id' => $t->room_id,
            'target_tabungan' => $t->target_tabungan,
            'total_terkumpul' => $t->total_terkumpul,
        ]),
    ]);
})->middleware('auth');


<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserType;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KaderController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/customregister', [AuthController::class, 'register'])->name('customregister');

// Shared login route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/customlogin', [AuthController::class, 'login'])->name('customlogin');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password authentication for Dokter and Kader
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:pasien')->group(function () {
    Route::get('/pasien/home', [PasienController::class, 'home'])->name('pasien.home');
});

Route::middleware('auth:dokter')->group(function () {
    Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');
});

Route::middleware('auth:kader')->group(function () {
    Route::get('/kader/dashboard', [KaderController::class, 'dashboard'])->name('kader.dashboard');
});

require __DIR__.'/auth.php';

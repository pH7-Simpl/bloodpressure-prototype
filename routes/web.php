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
    Route::get('/kader/patient/{id}', [KaderController::class, 'viewPatient'])->name('kader.view_patient');
    Route::get('/kader/patient/{id}/blood-pressure', [KaderController::class, 'editPatientBloodPressure'])->name('kader.editPatientBloodPressure');
    Route::get('/kader/blood-pressure/{id}', [KaderController::class, 'viewBloodPressure'])->name('kader.viewBloodPressure');
    Route::get('/kader/add-blood-pressure/{patient}', [KaderController::class, 'addBloodPressure'])->name('kader.addBloodPressure');
    Route::post('/kader/store-blood-pressure', [KaderController::class, 'storeBloodPressure'])->name('kader.storeBloodPressure');
    Route::get('/kader/edit-blood-pressure/{id}', [KaderController::class, 'editBloodPressure'])->name('kader.editBloodPressure');
    Route::delete('/kader/delete-blood-pressure/{id}', [KaderController::class, 'deleteBloodPressure'])->name('kader.deleteBloodPressure');
    Route::put('/kader/update-blood-pressure/{id}', [KaderController::class, 'updateBloodPressure'])->name('kader.updateBloodPressure');
    Route::post('/kader/add-patient/{patient_id}', [KaderController::class, 'addPatientToKader'])->name('kader.addPatientToKader');
    Route::post('/kader/unassign/{patient}', [KaderController::class, 'unassignPatient'])->name('kader.unassignPatient');
});

Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'terms-of-service')->name('terms.service');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserType;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\AssignmentController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/assignment-stats', [AssignmentController::class, 'getAssignmentStats'])
    ->name('assignment.stats');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/customregister', [AuthController::class, 'register'])->name('customregister');

// Shared login route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/customlogin', [AuthController::class, 'login'])->name('customlogin');

Route::post('/customlogout', [AuthController::class, 'logout'])->name('customlogout');

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
    Route::get('/pasien/profile', [PasienController::class, 'showProfile'])->name('pasien.profile');
    Route::post('/pasien/customupdateprofile', [PasienController::class, 'updateProfile'])->name('pasien.updateprofile');
    Route::delete('/pasien/customdeleteprofile', [PasienController::class, 'delete'])->name('pasien.delete');
    Route::get('/pasien/{id}/blood-pressure-data', [PasienController::class, 'showBloodPressureData']);
});

Route::middleware('auth:dokter')->group(function () {
    Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');
    Route::get('/dokter/profile', [DokterController::class, 'showProfile'])->name('dokter.profile');
    Route::post('/dokter/customupdateprofile', [DokterController::class, 'updateProfile'])->name('dokter.updateprofile');
    Route::post('/dokter/updatepassword', [DokterController::class, 'updatePassword'])->name('dokter.updatepassword');
    Route::delete('/dokter/customdeleteprofile', [DokterController::class, 'delete'])->name('dokter.delete');
    Route::get('/manage-patients', [DokterController::class, 'managePatients'])->name('dokter.managePatients');
    Route::post('/add-patient/{id}', [DokterController::class, 'addPatient'])->name('dokter.addPatient');
    Route::post('/remove-patient/{id}', [DokterController::class, 'removePatient'])->name('dokter.removePatient');
    Route::get('/dokter/patient/{id}/blood-pressure-data', [DokterController::class, 'getBloodPressureData']);
    Route::get('/dokter/blood-pressure/', [DokterController::class, 'viewBloodPressure'])->name('dokter.viewBloodPressure');
    Route::get('/dokter/manage-patients-medicine', [DokterController::class, 'managePatientsMedicine'])->name('dokter.managePatientsMedicine');
    Route::get('/dokter/patient/{patientId}/managepatientmedicine', [DokterController::class, 'viewMedicines'])->name('dokter.managepatientspecificmedicine');
    Route::get('/dokter/patient/{patientId}/managepatientmedicine/add', [DokterController::class, 'addMedicineForm'])->name('dokter.addMedicineForm');
    Route::post('/dokter/patient/{patientId}/managepatientmedicine/store', [DokterController::class, 'storeMedicine'])->name('dokter.storeMedicine');
    Route::get('/dokter/patient/{patientId}/managepatientmedicine/{medicineId}/edit', [DokterController::class, 'editMedicineForm'])->name('dokter.editMedicineForm');
    Route::put('/dokter/patient/{patientId}/managepatientmedicine/{medicineId}/update', [DokterController::class, 'updateMedicine'])->name('dokter.updateMedicine');
    Route::delete('/dokter/patient/{patientId}/managepatientmedicine/{medicineId}/delete', [DokterController::class, 'deleteMedicine'])->name('dokter.deleteMedicine');
    Route::get('/dokter/manage-patients-suggestions', [DokterController::class, 'managePatientsSuggestions'])->name('dokter.managePatientsSuggestions');
    Route::get('/dokter/patient/{patientId}/managepatientsuggestions', [DokterController::class, 'viewSuggestions'])->name('dokter.managepatientspecificsuggestion');
    Route::get('/dokter/patient/{patientId}/managepatientsuggestions/add', [DokterController::class, 'addSuggestionsForm'])->name('dokter.addSuggestionsForm');
    Route::post('/dokter/patient/{patientId}/managepatientsuggestions/store', [DokterController::class, 'storeSuggestions'])->name('dokter.storeSuggestions');
    Route::get('/dokter/patient/{patientId}/managepatientsuggestions/{suggestionId}/edit', [DokterController::class, 'editSuggestionsForm'])->name('dokter.editSuggestionsForm');
    Route::put('/dokter/patient/{patientId}/managepatientsuggestions/{suggestionId}/update', [DokterController::class, 'updateSuggestions'])->name('dokter.updateSuggestions');
    Route::delete('/dokter/patient/{patientId}/managepatientsuggestions/{suggestionId}/delete', [DokterController::class, 'deleteSuggestions'])->name('dokter.deleteSuggestions');
    Route::get('/dokter/manage-patients-appointments', [DokterController::class, 'managePatientsAppointments'])->name('dokter.managePatientsAppointments');
    Route::get('/dokter/patient/{patientId}/managepatientappointments', [DokterController::class, 'viewAppointments'])->name('dokter.managepatientspecificappointment');
    Route::get('/dokter/patient/{patientId}/managepatientappointments/add', [DokterController::class, 'addAppointmentsForm'])->name('dokter.addAppointmentsForm');
    Route::post('/dokter/patient/{patientId}/managepatientappointments/store', [DokterController::class, 'storeAppointments'])->name('dokter.storeAppointments');
    Route::get('/dokter/patient/{patientId}/managepatientappointments/{appointmentId}/edit', [DokterController::class, 'editAppointmentsForm'])->name('dokter.editAppointmentsForm');
    Route::put('/dokter/patient/{patientId}/managepatientappointments/{appointmentId}/update', [DokterController::class, 'updateAppointments'])->name('dokter.updateAppointments');
    Route::delete('/dokter/patient/{patientId}/managepatientappointments/{appointmentId}/delete', [DokterController::class, 'deleteAppointments'])->name('dokter.deleteAppointments');
});

Route::middleware('auth:kader')->group(function () {
    Route::get('/kader/dashboard', [KaderController::class, 'dashboard'])->name('kader.dashboard');
    Route::get('/kader/profile', [KaderController::class, 'showProfile'])->name('kader.profile');
    Route::post('/kader/customupdateprofile', [KaderController::class, 'updateProfile'])->name('kader.updateprofile');
    Route::post('/kader/updatepassword', [KaderController::class, 'updatePassword'])->name('kader.updatepassword');
    Route::delete('/kader/customdeleteprofile', [KaderController::class, 'delete'])->name('kader.delete');
    Route::get('/kader/patient/{id}', [KaderController::class, 'viewPatient'])->name('kader.view_patient');
    Route::get('/kader/patient/{id}/blood-pressure', [KaderController::class, 'editPatientBloodPressure'])->name('kader.editPatientBloodPressure');
    Route::get('/kader/patient/{id}/blood-pressure-data', [KaderController::class, 'getBloodPressureData']);
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

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientTimelineController;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\PsychologistScheduleController;
use App\Http\Controllers\ServiceRateController;
use App\Http\Controllers\ServicePackageController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientPackageController;
use App\Http\Controllers\PatientPackageUsageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Patients
Route::get(
    '/patients/search',
    [PatientController::class, 'search']
)
    ->middleware('auth')
    ->name('patients.search');
    
Route::get('/patients-archived', [PatientController::class, 'archived'])
    ->name('patients.archived');

Route::get('/patients/{patient}/timelines/create', [
    PatientTimelineController::class,
    'create'
])->name('patients.timelines.create');

Route::post('/patients/{patient}/timelines', [
    PatientTimelineController::class,
    'store'
])->name('patients.timelines.store');

Route::patch(
    '/patients/{id}/restore',
    [PatientController::class, 'restore']
)->name('patients.restore');

Route::resource('patients', PatientController::class)
    ->middleware('auth');

// Psikolog
Route::get('/psychologists-archived', [PsychologistController::class, 'archived'])
    ->name('psychologists.archived');

Route::patch(
    '/psychologists/{id}/restore',
    [PsychologistController::class, 'restore']
)->name('psychologists.restore');    

Route::resource('psychologists', PsychologistController::class)
    ->middleware('auth');

// Skedule atau Jadwal Praktek
Route::get(
    '/psychologist-schedules/by-psychologist/{psychologist}',
    [PsychologistScheduleController::class, 'byPsychologist']
)
    ->middleware('auth')
    ->name('psychologist_schedules.by_psychologist');

Route::resource('psychologist_schedules', PsychologistScheduleController::class)
    ->middleware('auth');

Route::get(
    '/psychologist_schedules-archived',
    [PsychologistScheduleController::class, 'archived']
)->name('psychologist_schedules.archived');

Route::patch(
    '/psychologist_schedules/{id}/restore',
    [PsychologistScheduleController::class, 'restore']
)->name('psychologist_schedules.restore');     

// Master Tarif
Route::get('/service-rates/archived', [ServiceRateController::class, 'archived'])
    ->name('service_rates.archived');

Route::patch('/service-rates/{id}/restore', [ServiceRateController::class, 'restore'])
    ->name('service_rates.restore');

Route::resource('service_rates', ServiceRateController::class)
    ->middleware('auth');

//Package    

Route::get(
    '/patient-packages/by-patient/{patient}',
    [PatientPackageController::class, 'byPatient']
)
    ->middleware('auth')
    ->name('patient_packages.by_patient');

Route::get(
    '/service-packages/archived',
    [ServicePackageController::class, 'archived'])
    ->middleware('auth')
    ->name('service_packages.archived');


Route::patch(
    '/service-packages/{id}/restore',
    [ServicePackageController::class, 'restore'])
    ->middleware('auth')
    ->name('service_packages.restore');    

Route::resource('service_packages', ServicePackageController::class)
    ->middleware('auth');


//Organisasi

Route::get(
    '/organisasis/archived',
    [OrganizationController::class, 'archived']
)
    ->middleware('auth')
    ->name('organizations.archived');

Route::patch(
    '/organisasis/{id}/restore',
    [OrganizationController::class, 'restore']
)
    ->middleware('auth')
    ->name('organizations.restore');

Route::resource(
    'organizations',
    OrganizationController::class
)->middleware('auth');


    //Branch
Route::get(
    '/branchess/archived',
    [BranchController::class, 'archived']
)
    ->middleware('auth')
    ->name('branches.archived');

Route::patch(
    '/branchess/{id}/restore',
    [BranchController::class, 'restore']
)
    ->middleware('auth')
    ->name('branches.restore');

Route::resource(
    'branches',
    BranchController::class
)->middleware('auth');

//Appointmen
Route::get('/appointments/archived', [AppointmentController::class, 'archived'])
    ->middleware('auth')
    ->name('appointments.archived');

Route::patch('/appointments/{id}/restore', [AppointmentController::class, 'restore'])
    ->middleware('auth')
    ->name('appointments.restore');

// Route::get(
//     '/appointments/psychologist-schedules/{psychologist}',
//     [AppointmentController::class, 'psychologistSchedules']
// )
//     ->middleware('auth')
//     ->name('appointments.psychologist_schedules');    
Route::get(
    '/appointments/by-psychologist/{psychologist}/{date}',
    [AppointmentController::class, 'byPsychologistDate']
)
    ->middleware('auth')
    ->name('appointments.by_psychologist_date');
    
Route::resource('appointments', AppointmentController::class)
    ->middleware('auth');

    //PaketPasien
Route::get('/patient-packages/archived', [
    PatientPackageController::class,
    'archived'
])
    ->middleware('auth')
    ->name('patient_packages.archived');

Route::patch('/patient-packages/{id}/restore', [
    PatientPackageController::class,
    'restore'
])
    ->middleware('auth')
    ->name('patient_packages.restore');

Route::get(
    '/patient-packages/{patientPackage}/details',
    [PatientPackageController::class, 'details']
)
    ->middleware('auth')
    ->name('patient_packages.details');    

Route::resource(
    'patient_packages',
    PatientPackageController::class
)
    ->middleware('auth');
    
    //Penggunaan Paket
Route::resource(
    'patient_package_usages',
    PatientPackageUsageController::class
)
    ->middleware('auth');
    
require __DIR__.'/auth.php';




<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientTimelineController;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\PsychologistScheduleController;


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
Route::resource('psychologist_schedules', PsychologistScheduleController::class)
    ->middleware('auth');
Route::get('/psychologist_schedules-archived', [PsychologistScheduleController::class, 'archived'])
    ->name('psychologist_schedules.archived');
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


require __DIR__.'/auth.php';


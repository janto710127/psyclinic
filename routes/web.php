<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientTimelineController;

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

Route::resource('patients', PatientController::class)
    ->middleware('auth');

Route::get('/patients/{patient}/timelines/create', [
    PatientTimelineController::class,
    'create'
])->name('patients.timelines.create');

Route::post('/patients/{patient}/timelines', [
    PatientTimelineController::class,
    'store'
])->name('patients.timelines.store');

require __DIR__.'/auth.php';

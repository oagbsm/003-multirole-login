<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified','rolemanager:user'])->name('dashboard');

Route::get('/business', function () {
    return view('business.dashboard');
})->middleware(['auth', 'verified','rolemanager:business'])->name('business');

Route::get('/business/create', [SurveyController::class, 'create'])
    ->middleware(['auth', 'verified', 'rolemanager:business'])
    ->name('business.create-survey');

    

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified','rolemanager:admin'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/protect', [DashboardController::class, 'protectedMethod'])->name('protect');
});


//SURVEY FUNCTIONALITY 

//CREATE SURVEY

Route::post('business/create', [SurveyController::class, 'store'])->name('survey.store');

//vjew surveys 

Route::get('/business/viewsurvey', [SurveyController::class, 'viewsurvey'])
    ->middleware(['auth', 'verified', 'rolemanager:business'])
    ->name('business.viewsurvey');

    Route::get('/surveys/{id}', [SurveyController::class, 'show'])
    ->middleware(['auth', 'verified', 'rolemanager:admin']) // Add rolemanager:admin middleware here
    ->name('surveys.show');

require __DIR__.'/auth.php';

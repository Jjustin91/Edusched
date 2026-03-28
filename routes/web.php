<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ADMIN ROUTES
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('admin.dashboard');
});

// FACULTY ROUTES
Route::middleware(['auth', 'verified', 'role:faculty'])->group(function () {
    Route::get('/faculty/schedule', function () {
        return view('faculty.schedule'); 
    })->name('faculty.schedule');

    Route::get('/faculty/calendar', function () {
        return view('calendar');
    })->name('faculty.calendar');
});

// STUDENT ROUTES
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/student/home', function () {
        return view('student.home'); 
    })->name('student.home');

    Route::get('/student/appointments', [AppointmentController::class, 'index'])
        ->name('appointments');
});

// SHARED ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
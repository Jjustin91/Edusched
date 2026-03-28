<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ADMIN ROUTES
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    
    // Add these three new routes for Edit, Update, and Delete
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
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
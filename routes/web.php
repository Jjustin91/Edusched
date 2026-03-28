<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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
    // Replaced the closure with the controller method
    Route::get('/faculty/schedule', [AppointmentController::class, 'facultyIndex'])->name('faculty.schedule');
    
    // New route for approving/declining appointments
    Route::patch('/faculty/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('faculty.appointments.status');

    Route::get('/faculty/calendar', function () {
        return view('calendar');
    })->name('faculty.calendar');
});

// STUDENT ROUTES
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/student/home', function () {
        return view('student.home'); 
    })->name('student.home');

    // NEW: Route for viewing a specific department
    Route::get('/student/department/{department}', [StudentController::class, 'showDepartment'])->name('student.department');

    // Replaced the 'index' method with 'studentIndex' to match our controller
    Route::get('/student/appointments', [AppointmentController::class, 'studentIndex'])->name('appointments');
    
    // New route for students to submit a booking
    Route::post('/student/appointments', [AppointmentController::class, 'store'])->name('student.appointments.store');
});

// SHARED ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // ==========================================
    // STUDENT METHODS
    // ==========================================

    // Displays the student's appointments and the booking form
    public function studentIndex()
    {
        // Fetch appointments belonging to the logged-in student
        $appointments = Appointment::where('student_id', Auth::id())
            ->with('faculty') // Pulls in the faculty details automatically
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Fetch all faculty members so the student can select one from a dropdown
        $faculties = User::where('role', 'faculty')->get();

        return view('student.appointments', compact('appointments', 'faculties'));
    }

    // Handles saving a new appointment requested by a student
    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now', // Must be a future date
            'purpose' => 'required|string|max:255',
        ]);

        Appointment::create([
            'student_id' => Auth::id(),
            'faculty_id' => $request->faculty_id,
            'appointment_date' => $request->appointment_date,
            'purpose' => $request->purpose,
            'status' => 'pending', // Always starts as pending
        ]);

        return redirect()->back()->with('success', 'Appointment requested successfully! Waiting for faculty approval.');
    }


    // ==========================================
    // FACULTY METHODS
    // ==========================================

    // Displays the faculty dashboard with their specific schedule
    public function facultyIndex()
    {
        // Fetch appointments where the logged-in user is the faculty member
        $appointments = Appointment::where('faculty_id', Auth::id())
            ->with('student') // Pulls in the student details
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('faculty.schedule', compact('appointments'));
    }

    // Handles approving or declining an appointment
    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Security check: Ensure the logged-in faculty actually owns this appointment
        if ($appointment->faculty_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:approved,declined',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        $message = $request->status === 'approved' ? 'Appointment approved!' : 'Appointment declined.';
        
        return redirect()->back()->with('success', $message);
    }
}
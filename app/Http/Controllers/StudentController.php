<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    // Fetches and displays faculty members for a specific department
    public function showDepartment($department)
    {
        // Find all faculty members who belong to this specific department
        $faculties = User::where('role', 'faculty')
                        ->where('department', $department)
                        ->get();

        // Pass the data to our new view
        return view('student.department', compact('faculties', 'department'));
    }
}
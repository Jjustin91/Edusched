<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    // 1. The Dashboard Method
    public function dashboard(Request $request)
    {
        // 1. Get the search term from the URL (if any)
        $search = $request->input('search');

        // 2. Query Students with Search and Pagination (10 per page)
        $students = User::where('role', 'student')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(5);

        // 3. Query Faculty with Search and Pagination (10 per page)
        $teachers = User::where('role', 'faculty')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('department', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('admin.dashboard', compact('students', 'teachers', 'search'));
    }

    // 2. Displays the Creation Form
    public function create()
    {
        return view('admin.create');
    }

    // 3. Handles Saving the New User
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,faculty'], // Keep this validation
            // Add validation for the new Department field. We allow it to be nullable.
            'department' => ['nullable', 'in:CEA,CITC,CSM,COT,SHS,CSTE,MED'], 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // Save the department data!
            'department' => $request->department, 
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Account created successfully!');
    }

    // Displays the Edit Form
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    // Handles Saving the Updated User Data
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Ignore this user's current email when checking if the email is unique
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:student,faculty'],
            // Add validation for the department during updates as well.
            'department' => ['nullable', 'in:CEA,CITC,CSM,COT,SHS,CSTE,MED'], 
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            // Update the department data!
            'department' => $request->department, 
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Account updated successfully!');
    }

    // Handles Deleting the User
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Account successfully deleted.');
    }

    // Generates a PDF Report of all registered users
    public function exportPDF()
    {
        // Fetch all data (we don't paginate the PDF, we want the whole report)
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'faculty')->get();

        // Load a special Blade view and pass the data to it
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.report', compact('students', 'teachers'));
        
        // Download the file
        return $pdf->download('EduSched_User_Report.pdf');
    }
}
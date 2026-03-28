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
        $search = $request->input('search');

        $facultyQuery = User::where('role', 'faculty');
        if ($search) {
            $facultyQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $teachers = $facultyQuery->paginate(10);

        $studentQuery = User::where('role', 'student');
        if ($search) {
            $studentQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $students = $studentQuery->paginate(10);

        return view('admin.dashboard', compact('teachers', 'students', 'search'));
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
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:student,faculty'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
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
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Account updated successfully!');
    }

    // Handles Deleting the User
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Account successfully deleted.');
    }
}
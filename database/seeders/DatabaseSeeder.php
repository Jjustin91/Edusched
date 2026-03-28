<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@edusched.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Faculty Member',
            'email' => 'faculty@edusched.com',
            'password' => Hash::make('password123'),
            'role' => 'faculty',
        ]);

        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@edusched.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the primary system admin account
        User::create([
            'name' => 'Jonathan T. Justiniani',
            'email' => 'admin@edusched.com',
            'password' => Hash::make('password123'), // Your default password
            'role' => 'admin',
        ]);
    }
}
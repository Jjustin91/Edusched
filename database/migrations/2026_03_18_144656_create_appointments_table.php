<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_appointments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys linking to the users table
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('users')->onDelete('cascade');
            
            // Appointment details
            $table->dateTime('appointment_date');
            $table->string('purpose');
            $table->string('status')->default('pending'); // Can be: pending, approved, declined
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

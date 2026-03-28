<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // 1. Allow these fields to be saved to the database
    protected $fillable = [
        'student_id',
        'faculty_id',
        'appointment_date',
        'purpose',
        'status',
    ];

    // 2. Define the relationship to the Student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // 3. Define the relationship to the Faculty
    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }
}
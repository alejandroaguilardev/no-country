<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalRetired extends Model
{
    // Define the table name if it's not the plural of the model name
    protected $table = 'historical_retireds';

    // Define the fillable fields
    protected $fillable = [
        'student_name',
        'course_description',
        'authorized_name',
        'tutor_name',
        'date',
        'status',
        'presence',
        'leave_alone',
    ];

    protected $hidden = [
        'student_id',
        'course_id',
        'authorized_id',
        'tutor_id',
        'created_at',
        'updated_at',
    ];

    // Define relationships

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function authorized()
    {
        return $this->belongsTo(Authorized::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}

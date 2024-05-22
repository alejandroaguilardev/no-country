<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'email',
        'password',
        'course_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}

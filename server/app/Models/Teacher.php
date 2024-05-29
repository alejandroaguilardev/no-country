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
    ];

    protected $hidden = [
        'course_id',
        'password',
        'created_at',
        'updated_at',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}

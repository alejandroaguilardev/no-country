<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'last_name',
        'document_number',
        'course_id',
        'tutor_id',
        'authorized_id',

    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function authorized(): BelongsTo
    {
        return $this->belongsTo(Authorized::class);
    }

    public function retired(): HasOne
    {
        return $this->hasOne(Retired::class);
    }
}

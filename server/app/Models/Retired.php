<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retired extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'status',
        'presence',
        'leavesAlone'
    ];
    protected $hidden = [
        'id',
        'student_id',
        'created_at',
        'updated_at',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

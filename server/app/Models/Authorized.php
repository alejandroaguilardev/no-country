<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Authorized extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'document_number',
        'phone',
        'photo',
    ];

    protected $hidden = [
        'tutor_id',
        'created_at',
        'updated_at',
    ];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}

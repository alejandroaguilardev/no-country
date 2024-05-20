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
        'lastname',
        'documentnumber',
        'phone',
        'photo',
        'tutorid',
    ];
    
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}

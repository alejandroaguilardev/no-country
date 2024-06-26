<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'document_number',
        'phone',
        'email',
        'photo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function authorizeds(): HasMany
    {
        return $this->hasMany(Authorized::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}

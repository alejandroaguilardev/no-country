<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($tutor) {
            DB::table('authorizeds')->insert([
                'name' => $tutor->name,
                'last_name' => $tutor->last_name,
                'document_number' => $tutor->document_number,
                'phone' => $tutor->phone,
                'photo' => $tutor->photo,
                'tutor_id' => $tutor->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}

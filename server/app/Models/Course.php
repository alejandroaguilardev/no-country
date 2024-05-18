<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'description'
    ]; 

    public function teacher(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}

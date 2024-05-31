<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function getRecord(string $email)
    {
        $user = User::with("tutor", "teacher", "role")->where('email', $email)->first();
        return $user;
    }
}

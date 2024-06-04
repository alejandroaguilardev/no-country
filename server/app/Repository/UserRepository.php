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

    public function getStudentsRecord(int $id)
    {
        $user = User::with('tutor', 'tutor.students' )->where('id', $id)->first();
        return $user->tutor->students;
    }

    public function getAuthorizedsRecord(int $id)
    {
        $user = User::with('tutor', 'tutor.authorizeds' )->where('id', $id)->first();
        return $user->tutor->authorizeds;
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tutor;
use Illuminate\Database\Seeder;

class TutorSeeder extends Seeder
{
    private $tutors_id = [];

    public function run(): void
    {

        $default_roles = app('default_roles');
        $default_users = app('default_users');
        $total_tutors = app('total_tutors');

        $user =  User::factory()->create([ "role_id"=> $default_roles["tutor"]["id"], "email"=> $default_users["tutor"]["email"], "password"=>$default_users["tutor"]["password"]]);

        $this->createTutor($user->email, $user->id);

        for ($i=1; $i < $total_tutors; $i++) { 
            $user =  User::factory()->create(["role_id"=>$default_roles["tutor"]["id"]]);        
            $this->createTutor($user->email, $user->id);

        }
        app()->instance('tutors_id', $this->tutors_id);

    }

    private function createTutor(string $email,  string $id)
    {
        $tutor = Tutor::factory()->create(['email'=>$email,'user_id'=> $id]);
        $this->tutors_id[] = $tutor->id;
    }
}

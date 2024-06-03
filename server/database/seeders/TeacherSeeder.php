<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_roles = app('default_roles');
        $default_users = app('default_users');
        $courses_id = app('courses_id');

        $user = User::factory()->create(["role_id"=> $default_roles["teacher"]["id"], "email"=> $default_users["teacher"]["email"], "password"=>$default_users["teacher"]["password"]]);
        Teacher::factory()->create(['email'=>$user->email,'course_id' => $courses_id[0], 'user_id'=> $user->id]); 

        for ($i = 0; $i < count($courses_id); $i++) {
            $user = User::factory()->create(["role_id"=>$default_roles["teacher"]["id"]]);
            Teacher::factory()->create(['email'=>$user->email,'course_id' => $courses_id[$i], 'user_id'=> $user->id]);
        }
    }
}

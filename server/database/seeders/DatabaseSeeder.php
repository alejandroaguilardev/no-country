<?php

namespace Database\Seeders;

use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $total_tutors = 420;
    private $default_random_students = 3;

    private $default_users = [
        "teacher"=>["email"=>"teacher@example.com", "password" => "12345678"], 
        "tutor"=>["email"=>"tutor@example.com", "password" => "12345678"], 
        "admin"=>["email"=>"admin@example.com", "password" => "12345678"], 
    ];

    private $default_roles = [
        "admin"=>["id"=>1,"name"=>"admin"], 
        "teacher"=>["id"=>2,"name"=>"teacher"], 
        "tutor"=>["id"=>3,"name"=>"tutor"], 
    ];

    private $default_courses = [
        '1A', '1B', '1C', '2A', '2B', '2C',
        '3A', '3B', '3C', '4A', '4B', '4C',
        '5A', '5B', '5C', '6A', '6B', '6C',
        '7A', '7B', '7C',
    ];

    public function run(): void
    {
        app()->instance('total_tutors', $this->total_tutors);
        app()->instance('default_random_students', $this->default_random_students);
        app()->instance('default_roles', $this->default_roles);
        app()->instance('default_users', $this->default_users);
        app()->instance('default_courses', $this->default_courses);

        $this->call(RoleSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(TutorSeeder::class);
        $this->call(StudentSeeder::class);

        $this->createAdmin();
    }

    protected function createAdmin() {
        $default_roles = app('default_roles');
        $user = User::factory()->create(["email"=>"admin@example.com","password"=>"12345678", "role_id"=>$default_roles["admin"]["id"]]);
        Tutor::factory()->create(['email'=>$user->email,'user_id'=> $user->id]);
    }
}



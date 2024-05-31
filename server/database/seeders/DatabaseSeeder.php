<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Retired;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Tutor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $totalStudents = 420;

    private $default_courses = [
        '1A', '1B', '1C', '2A', '2B', '2C',
        '3A', '3B', '3C', '4A', '4B', '4C',
        '5A', '5B', '5C', '6A', '6B', '6C',
        '7A', '7B', '7C',
    ];

    private $default_roles = ["admin", "teacher", "tutor"];

    private $courses_id = [];
    private $roles_id = [];

    public function run(): void
    {
        $this->roles();

        foreach ($this->default_courses as $default_course) {
            $course = Course::factory()->create(['description' => $default_course]);
            
            $user = User::factory()->create(["password"=>"12345678", "role_id"=>$this->roles_id[1]]);

            Teacher::factory()->create(['email'=>$user->email,'course_id' => $course->id, 'user_id'=> $user->id]);

            $this->courses_id[] = $course->id;
        }

        User::factory()->count($this->totalStudents)->create(["password"=>"12345678", "role_id"=>$this->roles_id[2]])->each(function ($user) {
            $tutor = Tutor::factory()->create(['email'=>$user->email,'user_id'=> $user->id]);

            $student=Student::factory()->create([
                'course_id' => $this->courseRandom(), 
                'tutor_id' => $tutor->id, 
                'authorized_id' => $tutor->id]);

            Retired::create([
                'student_id' => $student->id,
                'date' => Carbon::now(), 
                'status' => false, 
                'presence' => true, 
                'leaveAlone'=> false
            ]);
        });


      $this->admin();
    }



    private function roles() {
        foreach ($this->default_roles as $default_rol) {
            $role = Role::factory()->create(['name' => $default_rol]);
            $this->roles_id[] = $role->id;
        }
    }

    
    private function admin() {
       User::factory()->create(["email"=>"admin@example.com","password"=>"12345678", "role_id"=>$this->roles_id[0]]);
    }

    private function courseRandom()
    {
        $randomKey = array_rand($this->courses_id);
        return $this->courses_id[$randomKey];
    }
}

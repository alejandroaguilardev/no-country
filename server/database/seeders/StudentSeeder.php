<?php

namespace Database\Seeders;

use App\Models\Authorized;
use App\Models\Retired;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StudentSeeder extends Seeder
{

    public function run(): void
    {
        $courses_id = app('courses_id');
        $tutors_id = app('tutors_id');
        $default_random_students = app('default_random_students');

        foreach ($tutors_id as $tutor_id) {
            for ($i=0; $i < $this->randomStudents($default_random_students); $i++) { 
                $authorized = Authorized::factory()->create([
                    'tutor_id' => $tutor_id, 
                ]);

                $student= Student::factory()->create([
                    'course_id' => CourseSeeder::courseRandom($courses_id),
                    'tutor_id' => $tutor_id, 
                    'authorized_id' => $authorized->id
                ]);
    
                Retired::create([
                    'student_id' => $student->id,
                    'date' => Carbon::now(), 
                    'status' => false, 
                    'presence' => true,
                    'leaveAlone'=> false
                ]);
            }
        }        
    }
    private function randomStudents($count) {
        return rand(1, $count);
    }
}

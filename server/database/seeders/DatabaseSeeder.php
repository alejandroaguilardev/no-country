<?php

namespace Database\Seeders;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Tutor;
use App\Models\Authorized;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $courses = [
            '1A', '1B', '1C', '2A', '2B', '2C',
            '3A', '3B', '3C', '4A', '4B', '4C',
            '5A', '5B', '5C', '6A', '6B', '6C',
            '7A', '7B', '7C',
        ];
        
        $courses_id= [ ];
        foreach ($courses as $courseDescription) {
         $course=Course::factory()->create(['description' => $courseDescription]);
         Teacher::factory()->create(['course_id' => $course->id]); 
         $courses_id[]=$course->id;
        }
        
        Tutor::factory()->count(1)->create()->each(function ($tutor) {
            $authorized=$tutor->authorizeds()->create(Authorized::factory()->make()->toArray());
            $tutor->students()->create(Student::factory()->create(['name'=> 'pepita','lastname'=>'pepita', 'documentnumber'=>123456,'course_id' =>1,'tutor_id'=>$tutor->id,'authorized_id'=>$authorized->id])->make()->toArray());
        });
        //tutores
        $this->call(TutorSeeder::class);
    }


}

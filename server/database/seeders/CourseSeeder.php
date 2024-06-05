<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
 
    private $courses_id = [];
    private static $course_id_assign=[];

    public function run(): void
    {
        $default_courses = app('default_courses');
        foreach ($default_courses as $default_course) {
            $course =Course::factory()->create(['description' => $default_course]);
            $this->courses_id[] = $course->id;
        }
        app()->instance('courses_id', $this->courses_id);
    }

    public static function courseRandom($courses_id)
    {   
        foreach ($courses_id as $course_id) {
            if(!in_array($course_id, self::$course_id_assign)) {
                $randomKey = array_rand($courses_id);
                return $courses_id[$randomKey];
            }
        }
        $randomKey = array_rand($courses_id);
        return $courses_id[$randomKey];
    }
}

<?php

namespace Database\Seeders;
use App\Models\Course;
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

        foreach ($courses as $courseDescription) {
         Course::factory()->create(['description' => $courseDescription]);
        }

        //tutores
        $this->call(TutorSeeder::class);
    }
}

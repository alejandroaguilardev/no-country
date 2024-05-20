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
    //     Course::factory(21)->create();

        Course::factory()->create(['description' => '1A']);
        Course::factory()->create(['description' => '1B']);
        Course::factory()->create(['description' => '1C']);
        Course::factory()->create(['description' => '2A']);
        Course::factory()->create(['description' => '2B']);
        Course::factory()->create(['description' => '2C']);
        Course::factory()->create(['description' => '3A']);
        Course::factory()->create(['description' => '3B']);
        Course::factory()->create(['description' => '3C']);
        Course::factory()->create(['description' => '4A']);
        Course::factory()->create(['description' => '4B']);
        Course::factory()->create(['description' => '4C']);
        Course::factory()->create(['description' => '5A']);
        Course::factory()->create(['description' => '5B']);
        Course::factory()->create(['description' => '5C']);
        Course::factory()->create(['description' => '6A']);
        Course::factory()->create(['description' => '6B']);
        Course::factory()->create(['description' => '6C']);
        Course::factory()->create(['description' => '7A']);
        Course::factory()->create(['description' => '7B']);
        Course::factory()->create(['description' => '7C']);
    }
}

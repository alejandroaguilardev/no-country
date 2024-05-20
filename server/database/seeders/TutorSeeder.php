<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tutor;
use App\Models\Authorized;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generar 210 tutores y para cada uno generar un autorizado
        Tutor::factory()->count(1)->create()->each(function ($tutor) {
            $tutor->authorizeds()->create(Authorized::factory()->make()->toArray());
        });
    }
}

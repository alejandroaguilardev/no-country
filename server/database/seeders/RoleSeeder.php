<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  
    public function run(): void
    {
        $default_roles = app('default_roles');

        foreach ($default_roles as $default_rol) {
            Role::factory()->create(['name' => $default_rol["name"]]);
        }
    }
}

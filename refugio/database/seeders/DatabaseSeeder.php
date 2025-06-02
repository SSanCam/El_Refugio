<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Animal;
use App\Models\Adoption;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders de la base de datos.
     */
    public function run(): void
    {
        // Crear usuarios y animales antes
        $users = User::factory(10)->create();
        $animals = Animal::factory(15)->create();

        // Crear adopciones con esos usuarios y animales ya creados
        Adoption::factory(10)->make()->each(function ($adoption) use ($users, $animals) {
            $adoption->animal_id = $animals->random()->id;
            $adoption->user_id = $users->random()->id;
            $adoption->save();
        });
    }
}

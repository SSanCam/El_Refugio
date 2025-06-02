<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Animal;
use App\Models\AnimalMedication;
use App\Models\Adoption;
use App\Models\Sponsorship;


class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders de la base de datos.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Animal::factory(15)->create();
        Adoption::factory(10)->create();
    }
}

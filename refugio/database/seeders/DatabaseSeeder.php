<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Database\Seeders\AnimalSeeder;
use Database\Seeders\AdoptionSeeder;
use Database\Seeders\FosterSeeder;
use Database\Seeders\VeterinaryHistorySeeder;
use Database\Seeders\AnimalMedicationSeeder;
use Database\Seeders\AdoptionRequestSeeder;
use Database\Seeders\FosterRequestSeeder;
use Database\Seeders\VolunteerRequestSeeder;
use Database\Seeders\ContactMessageSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AnimalSeeder::class,
            AdoptionSeeder::class,
            FosterSeeder::class,
            VeterinaryHistorySeeder::class,
            AnimalMedicationSeeder::class,
            AdoptionRequestSeeder::class,
            FosterRequestSeeder::class,
            VolunteerRequestSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
    
}

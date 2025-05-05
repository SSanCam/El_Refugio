<?php

namespace Database\Seeders;

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

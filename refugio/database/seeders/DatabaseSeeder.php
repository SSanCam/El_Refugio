<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Animal;
use App\Models\VeterinaryHistory;
use App\Models\AnimalMedication;
use App\Models\AnimalRequest;
use App\Models\ContactMessage;
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
        VeterinaryHistory::factory(20)->create();
        AnimalMedication::factory(20)->create();
        AnimalRequest::factory(10)->adoption()->create();
        AnimalRequest::factory(10)->foster()->create();       
        ContactMessage::factory(10)->create();
        Adoption::factory(10)->create();
        Sponsorship::factory(10)->create();

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adoption;
use App\Models\User;
use App\Models\Animal;
use Carbon\Carbon;

class AdoptionSeeder extends Seeder
{
    public function run(): void
    {
        $animals = Animal::where('status', 'adopted')->get();
        $users   = User::all();

        foreach ($animals as $animal) {
            $adopter = $users->random();

            Adoption::factory()->create([
                'animal_id'     => $animal->id,
                'user_id'       => $adopter->id,
                'adoption_date' => Carbon::now()
                    ->subDays(rand(5, 120))
                    ->toDateString(),
                'contract_file' => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765296417/contr_adopted_fq5quj.png',
            ]);
        }
    }
}

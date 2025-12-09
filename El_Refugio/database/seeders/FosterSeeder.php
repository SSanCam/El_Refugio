<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Foster;
use App\Models\User;
use App\Models\Animal;
use Carbon\Carbon;

class FosterSeeder extends Seeder
{
    public function run(): void
    {
        $animals = Animal::where('status', 'fostered')->get();
        $users   = User::all();

        foreach ($animals as $animal) {
            $tutor = $users->random();

            Foster::factory()->create([
                'animal_id'     => $animal->id,
                'user_id'       => $tutor->id,
                'start_date'    => Carbon::now()
                    ->subDays(rand(10, 200))
                    ->toDateString(),
                'end_date'      => rand(0, 1)
                    ? Carbon::now()->subDays(rand(1, 9))->toDateString()
                    : null,
                'contract_file' => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765296417/contr_fostered_q9royr.png',
            ]);
        }
    }
}

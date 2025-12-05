<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adoption;
use App\Models\User;
use App\Models\Animal;
use Carbon\Carbon;

class AdoptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuarios clave creados en UserSeeder
        $oficina = User::where('email', 'adoptante.oficina@ejemplo.test')->first();
        $marta  = User::where('email', 'marta.acogida@ejemplo.test')->first();
        // Animales clave creados en AnimalSeeder
        $manteca  = Animal::where('name', 'Manteca')->first();
        $ciri     = Animal::where('name', 'Ciri')->first();

        $hoy = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | 1) Manteca – adopción con usuario web (Marta)
        |--------------------------------------------------------------------------
        | Usuario con registro web + adopción + acogida.
        */
        if ($marta && $manteca) {
            Adoption::factory()->create([
                'user_id'       => $marta->id,
                'animal_id'     => $manteca->id,
                'adoption_date' => $hoy->copy()->subMonth()->toDateString(),
                'comments'      => 'Adopción formalizada tras un periodo de acogida temporal.',
            ]);

            $manteca->update([
                'status'       => 'adopted',
                'availability' => 'unavailable',
            ]);
        }
        
        /*
        |--------------------------------------------------------------------------
        | 2) Ciri – adopción en oficina (Sara)
        |--------------------------------------------------------------------------
        | Usuario sin registro web + adopción en oficina.
        */
        if ($oficina && $ciri) {
            Adoption::factory()->create([
                'user_id'       => $oficina->id,
                'animal_id'     => $ciri->id,
                'adoption_date' => $hoy->copy()->subDays(10)->toDateString(),
                'comments'      => 'Adopción realizada en oficina por Sara.',
            ]);

            $ciri->update([
                'status'       => 'adopted',
                'availability' => 'unavailable',
            ]);
        }
    }

}
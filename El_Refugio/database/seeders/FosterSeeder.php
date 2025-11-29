<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Foster;
use App\Models\User;
use App\Models\Animal;
use Carbon\Carbon;

class FosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marta = User::where('email', 'marta.acogida@ejemplo.test')->first();

        $dama    = Animal::where('name', 'Dama')->first();
        $zurrapa = Animal::where('name', 'Zurrapa')->first();

        $hoy = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | 1) Dama – acogida ACTIVA con Marta
        |--------------------------------------------------------------------------
        | Dama no está disponible para adopción, pero sí en acogida.
        */
        if ($marta && $dama) {
            Foster::factory()->create([
                'user_id'   => $marta->id,
                'animal_id' => $dama->id,
                'comments'  => 'Acogida temporal para que Dama críe a sus cachorros en un entorno tranquilo.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2) Zurrapa – acogida FINALIZADA (histórico, mismo usuario)
        |--------------------------------------------------------------------------
        */
        if ($marta && $zurrapa) {
            Foster::factory()->create([
                'user_id'   => $marta->id,
                'animal_id' => $zurrapa->id,
                'comments'  => 'Acogida finalizada; Zurrapa vuelve al refugio para difusión de adopción.',
            ]);
        }
    }
}

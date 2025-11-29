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
        $carlos  = User::where('email', 'carlos.adoptante@ejemplo.test')->first();
        $marta   = User::where('email', 'marta.acogida@ejemplo.test')->first();

        // Animales clave creados en AnimalSeeder
        $puchero  = Animal::where('name', 'Puchero')->first();
        $garbanzo = Animal::where('name', 'Garbanzo')->first();
        $manteca  = Animal::where('name', 'Manteca')->first();

        $hoy = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | 1) Puchero – adopción tramitada en oficina (sin acceso web)
        |--------------------------------------------------------------------------
        | La adopción se registra a nombre de "Ana Oficina" (is_active = false),
        | pero SIEMPRE con user_id != null.
        */
        if ($oficina && $puchero) {
            Adoption::factory()->create([
                'user_id'       => $oficina->id,
                'animal_id'     => $puchero->id,
                // tienes default CURRENT_DATE en la migración, esto es opcional:
                'adoption_date' => $hoy->copy()->subMonths(4)->toDateString(),
                'comments'      => 'Adopción gestionada íntegramente por el personal administrativo, sin acceso web para la adoptante.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2) Garbanzo – adopción con usuario web (Carlos)
        |--------------------------------------------------------------------------
        */
        if ($carlos && $garbanzo) {
            Adoption::factory()->create([
                'user_id'       => $carlos->id,
                'animal_id'     => $garbanzo->id,
                'adoption_date' => $hoy->copy()->subMonths(2)->toDateString(),
                'comments'      => 'Solicitud iniciada desde el formulario de adopción en la web y gestionada por administración.',
            ]);

            // Reflejarlo también en la tabla animals
            $garbanzo->update([
                'status'       => 'adopted',
                'availability' => 'unavailable',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3) Manteca – adopción con usuario web (Marta)
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
    }
}

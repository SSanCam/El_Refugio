<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;
use App\Models\AnimalImage;
use Carbon\Carbon;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper fechas
        $hoy = Carbon::now();
        
        /*
        |--------------------------------------------------------------------------
        | Dama (gata negra con cachorros, NO disponible aún)
        |--------------------------------------------------------------------------
        */
        $dama = Animal::create([
            'name'         => 'Dama',
            'species'      => 'cat',
            'breed'        => 'Mestiza europea',
            'sex'          => 'female',
            'size'         => 'small',
            'weight'       => 3.80,
            'height'       => 25,
            'neutered'     => false,
            'microchip'    => null,
            'birth_date'   => $hoy->copy()->subYears(2)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'unavailable',
            'entry_date'   => $hoy->copy()->subMonths(1)->toDateString(),
            'description'  => 'Gata negra rescatada con sus cachorros. Aún en proceso de recuperación, no disponible para adopción.',
            'observations' => 'Presenta calvas en el pelaje; en seguimiento veterinario.',
            'is_featured'  => false,
            'featured_at'  => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Garbanzo (chihuahua senior, recuperado y disponible)
        |--------------------------------------------------------------------------
        */
        $garbanzo = Animal::create([
            'name'         => 'Garbanzo',
            'species'      => 'dog',
            'breed'        => 'Chihuahua senior',
            'sex'          => 'male',
            'size'         => 'small',
            'weight'       => 4.20,
            'height'       => 30,
            'neutered'     => true,
            'microchip'    => 'CHIHU-0001',
            'birth_date'   => $hoy->copy()->subYears(10)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'available',
            'entry_date'   => $hoy->copy()->subMonths(3)->toDateString(),
            'description'  => 'Chihuahua senior recuperado, tranquilo y cariñoso, listo para adopción.',
            'observations' => 'Apto para hogar calmado; revisiones veterinarias periódicas.',
            'is_featured'  => true,
            'featured_at'  => $hoy->copy()->subWeeks(1)->toDateTimeString(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Dana (galga recuperada de cazador, disponible)
        |--------------------------------------------------------------------------
        */
        $dana = Animal::create([
            'name'         => 'Dana',
            'species'      => 'dog',
            'breed'        => 'Galgo español',
            'sex'          => 'female',
            'size'         => 'large',
            'weight'       => 24.50,
            'height'       => 60,
            'neutered'     => true,
            'microchip'    => 'GALGO-0001',
            'birth_date'   => $hoy->copy()->subYears(4)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'available',
            'entry_date'   => $hoy->copy()->subMonths(2)->toDateString(),
            'description'  => 'Galga rescatada de un cazador. Cariñosa y sensible, preparada para encontrar familia.',
            'observations' => 'Muestra buena socialización con otros perros.',
            'is_featured'  => true,
            'featured_at'  => $hoy->copy()->subDays(10)->toDateTimeString(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Zurrapa (podenco maneto mediano) + cachorros Manteca, Mechado, Pimentón
        |--------------------------------------------------------------------------
        */
        $zurrapa = Animal::create([
            'name'         => 'Zurrapa',
            'species'      => 'dog',
            'breed'        => 'Podenco maneto',
            'sex'          => 'female',
            'size'         => 'medium', // como me dijiste
            'weight'       => 12.00,
            'height'       => 40,
            'neutered'     => false,
            'microchip'    => 'POD-0001',
            'birth_date'   => $hoy->copy()->subYears(3)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'available',
            'entry_date'   => $hoy->copy()->subMonths(1)->toDateString(),
            'description'  => 'Podenca maneta rescatada con camada. Perra activa y sociable.',
            'observations' => 'Encontrada atada a una farola. Camada en buen estado.',
            'is_featured'  => true,
            'featured_at'  => $hoy->copy()->subDays(5)->toDateTimeString(),
        ]);

        $manteca = Animal::create([
            'name'         => 'Manteca',
            'species'      => 'dog',
            'breed'        => 'Cruce de podenco maneto',
            'sex'          => 'unknown',
            'size'         => 'small',
            'weight'       => 4.00,
            'height'       => 25,
            'neutered'     => false,
            'microchip'    => null,
            'birth_date'   => $hoy->copy()->subMonths(3)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'available',
            'entry_date'   => $hoy->copy()->subMonths(1)->toDateString(),
            'description'  => 'Cachorro de Zurrapa, juguetón y sociable.',
            'observations' => null,
            'is_featured'  => false,
            'featured_at'  => null,
        ]);

        $mechado = Animal::create([
            'name'         => 'Mechado',
            'species'      => 'dog',
            'breed'        => 'Cruce de podenco maneto',
            'sex'          => 'unknown',
            'size'         => 'small',
            'weight'       => 4.20,
            'height'       => 25,
            'neutered'     => false,
            'microchip'    => null,
            'birth_date'   => $hoy->copy()->subMonths(3)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'available',
            'entry_date'   => $hoy->copy()->subMonths(1)->toDateString(),
            'description'  => 'Cachorro de Zurrapa, curioso y activo.',
            'observations' => null,
            'is_featured'  => false,
            'featured_at'  => null,
        ]);

        $pimenton = Animal::create([
            'name'         => 'Pimentón',
            'species'      => 'dog',
            'breed'        => 'Cruce de podenco maneto',
            'sex'          => 'unknown',
            'size'         => 'small',
            'weight'       => 4.10,
            'height'       => 25,
            'neutered'     => false,
            'microchip'    => null,
            'birth_date'   => $hoy->copy()->subMonths(3)->toDateString(),
            'status'       => 'sheltered',
            'availability' => 'available',
            'entry_date'   => $hoy->copy()->subMonths(1)->toDateString(),
            'description'  => 'Cachorro de Zurrapa, muy cariñoso.',
            'observations' => null,
            'is_featured'  => false,
            'featured_at'  => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Puchero (mestizo de Bretón, ya adoptado)
        |--------------------------------------------------------------------------
        */
        $puchero = Animal::create([
            'name'         => 'Puchero',
            'species'      => 'dog',
            'breed'        => 'Mestizo de Bretón español',
            'sex'          => 'male',
            'size'         => 'medium',
            'weight'       => 18.00,
            'height'       => 50,
            'neutered'     => true,
            'microchip'    => 'BRETON-0001',
            'birth_date'   => $hoy->copy()->subYears(5)->toDateString(),
            'status'       => 'adopted',
            'availability' => 'unavailable',
            'entry_date'   => $hoy->copy()->subMonths(4)->toDateString(),
            'description'  => 'Mestizo de Bretón rescatado de la carretera. Sociable y juguetón.',
            'observations' => 'Caso de éxito: actualmente adoptado.',
            'is_featured'  => true,
            'featured_at'  => $hoy->copy()->subWeeks(2)->toDateTimeString(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Imágenes asociadas (AnimalImage)
        |--------------------------------------------------------------------------
        */
        $images = [
            // Dama
            [
                'animal'   => $dama,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066278/e5b1d059-223a-4c4c-b747-915572a0342f_plzo0y.png',
                'alt_text' => 'Gata negra Dama con calvas en el pelaje y sus cachorros en el refugio.',
            ],
            [
                'animal'   => $dama,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066278/14d32e8e-0ad1-4d92-a890-b9e01bfdbaca_ufqmii.png',
                'alt_text' => 'Dama descansando con sus cachorros, aún no disponibles para adopción.',
            ],

            // Garbanzo (chihuahua senior recuperado)
            [
                'animal'   => $garbanzo,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066264/b2697239-33cc-4b01-8b44-e88df9aa3c32_qkl5lw.png',
                'alt_text' => 'Chihuahua senior Garbanzo mirando a cámara en el refugio.',
            ],
            [
                'animal'   => $garbanzo,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066263/36451b4c-c9d3-4319-9886-31b1823a28f2_mqu8yg.png',
                'alt_text' => 'Garbanzo descansando sobre una manta, ya recuperado.',
            ],
            [
                'animal'   => $garbanzo,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066260/ed333930-f245-4114-b59b-483d13955085_jwxiyc.png',
                'alt_text' => 'Primer plano de Garbanzo, listo para adopción.',
            ],

            // Dana (galga)
            [
                'animal'   => $dana,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066256/c246e237-9034-431f-9067-f31510a8913d_lgqwuq.png',
                'alt_text' => 'Galga Dana posando en el refugio tras su recuperación.',
            ],
            [
                'animal'   => $dana,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066255/bd2fbfed-0490-4c27-a5df-063c4107e0fb_gmq4ne.png',
                'alt_text' => 'Dana tumbada, tranquila, lista para adopción.',
            ],

            // Zurrapa
            [
                'animal'   => $zurrapa,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066215/696c456c-b764-483e-8d94-871e9acd2ebc_eqws1l.png',
                'alt_text' => 'Zurrapa, podenco maneto, encontrada atada a una farola.',
            ],
            [
                'animal'   => $zurrapa,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066217/6efe1c57-b001-48f3-b62c-5b14e27b0ec7_1_royb8b.png',
                'alt_text' => 'Zurrapa con sus cachorros en el refugio.',
            ],
            [
                'animal'   => $zurrapa,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066226/86035dab-cf08-464b-a1bd-b9653b2aad85_wxst2j.png',
                'alt_text' => 'Camada de cachorros de Zurrapa en el refugio.',
            ],

            // Cachorros de Zurrapa
            [
                'animal'   => $manteca,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066241/00f13251-706e-4e04-9687-cde7da5daeac_nhtfyb.png',
                'alt_text' => 'Cachorro Manteca, hijo de Zurrapa, listo para adoptar.',
            ],
            [
                'animal'   => $mechado,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066243/4e35b9d1-304e-4433-80d7-c27f6a5e982a_scuwbu.png',
                'alt_text' => 'Cachorro Mechado, hijo de Zurrapa, listo para adoptar.',
            ],
            [
                'animal'   => $pimenton,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066491/4015a36d-d78c-41a9-9a67-4948ea58972d_o9vvtb.png',
                'alt_text' => 'Cachorro Pimentón, hijo de Zurrapa, listo para adoptar.',
            ],

            // Puchero (antes y después + adopción)
            [
                'animal'   => $puchero,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066210/openart-image_Npg9FEyb_1764060339699_raw_v8hyiv.jpg',
                'alt_text' => 'Puchero recién recogido de la carretera.',
            ],
            [
                'animal'   => $puchero,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066209/30cf6bde-8f24-465c-a3ea-92b1e0ff5e5e_x7libc.png',
                'alt_text' => 'Puchero en el refugio, en proceso de recuperación.',
            ],
            [
                'animal'   => $puchero,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066208/72a6b2a8-93dc-4027-ad0f-3840617e505e_apmfjm.png',
                'alt_text' => 'Puchero jugando con otro perro en el refugio.',
            ],
            [
                'animal'   => $puchero,
                'url'      => 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1764066208/39b22f4b-3d02-4394-b7b1-a522d6a0df46_io4cly.png',
                'alt_text' => 'Puchero siendo adoptado por su nueva familia.',
            ],
        ];

        foreach ($images as $img) {
            AnimalImage::create([
                'animal_id' => $img['animal']->id,
                'url'       => $img['url'],
                'alt_text'  => $img['alt_text'],
            ]);
        }
    }
}

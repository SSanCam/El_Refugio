<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    public function definition(): array
    {
        // Especies
        $species = $this->faker->randomElement(['dog', 'cat']);

        // Razas realistas + mestizos
        $dogBreeds = [
            'Mestizo', 'Labrador Retriever', 'Pastor Alemán', 'Golden Retriever', 'Beagle',
            'Bulldog Francés', 'Braco', 'Pointer', 'Border Collie', 'Chihuahua'
        ];

        $catBreeds = [
            'Mestizo', 'Europeo común', 'Siamés', 'Persa', 'Británico', 'Azul Ruso'
        ];

        // Sexo
        $sex = $this->faker->randomElement(['male', 'female']);

        // Tamaño (para perros todos; gatos solo small/medium)
        $size = $species === 'dog'
            ? $this->faker->randomElement(['small', 'medium', 'large'])
            : $this->faker->randomElement(['small', 'medium']);

        // Estado + disponibilidad lógica
        $status = $this->faker->randomElement([
            'sheltered',
            'fostered',
            'adopted'
        ]);

        // availability según reglas que pediste
        if ($status === 'adopted') {
            $availability = 'unavailable';
        } elseif ($status === 'fostered') {
            // si está acogido, puede estar adoptable o no
            $availability = $this->faker->boolean(60) ? 'available' : 'unavailable';
        } else {
            // sheltered → puede estar en tratamiento
            $availability = $this->faker->boolean(80) ? 'available' : 'unavailable';
        }

        // Birthdate: animales realistas entre 3 meses y 12 años
        $birthDate = $this->faker->dateTimeBetween('-12 years', '-3 months')->format('Y-m-d');

        // Entry date siempre posterior al nacimiento
        $entryDate = $this->faker->dateTimeBetween($birthDate, 'now')->format('Y-m-d');

        // Observaciones si unavailable
        $observations = null;
        if ($availability === 'unavailable') {
            $observations = $this->faker->randomElement([
                'En recuperación veterinaria.',
                'Bajo tratamiento veterinario.',
                'En cuarentena preventiva.',
                'Recuperándose de una cirugía reciente.',
            ]);
        }

        return [
            'name'          => ucfirst($this->faker->unique()->firstName()),
            'species'       => $species,
            'breed'         => $species === 'dog'
                                ? $this->faker->randomElement($dogBreeds)
                                : $this->faker->randomElement($catBreeds),
            'sex'           => $sex,
            'size'          => $size,
            'weight'        => $this->faker->optional()->randomFloat(2, 2.0, 35.0),
            'height'        => $this->faker->optional()->randomFloat(2, 15.0, 70.0),
            'neutered'      => $this->faker->boolean(60),
            'microchip'     => $this->faker->optional()->numerify('################'),
            'birth_date'    => $birthDate,
            'status'        => $status,
            'availability'  => $availability,
            'entry_date'    => $entryDate,
            'description'   => $availability === 'unavailable'
                                ? 'Actualmente no disponible para adopción debido a tratamiento veterinario.'
                                : $this->faker->sentence(12),
            'observations'  => $observations,
            'is_featured'   => false,
            'featured_at'   => null,
        ];
    }
}

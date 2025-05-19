<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Estados posibles del animal
        $statuses = ['intake', 'sheltered', 'available', 'adopted', 'fostered', 'sponsored', 'deceased'];
        $status = fake()->randomElement($statuses);

        return [
            'name' => fake()->firstName(),
            'species' => fake()->randomElement(['dog', 'cat']),
            'breed' => fake()->word(),
            'age' => fake()->numberBetween(1, 15),
            'size' => fake()->randomElement(['small', 'medium', 'large']),
            'sex' => fake()->randomElement(['male', 'female', 'unknown']),
            'weight' => fake()->randomFloat(1, 2, 50),
            'status' => $status,
            'microchip' => fake()->boolean(70) ? fake()->uuid() : null, // 70% con microchip
            'description' => fake()->sentence(10),
            'image' => null, // Puedes añadir lógica para imágenes más adelante

            // Asignar un user_id solo si aplica
            'user_id' => in_array($status, ['adopted', 'fostered', 'sponsored'])
                ? User::inRandomOrder()->first()?->id
                : null,
        ];
    }
}

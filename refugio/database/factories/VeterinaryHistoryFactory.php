<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VeterinaryHistory>
 */
class VeterinaryHistoryFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'animal_id' => Animal::inRandomOrder()->first()?->id ?? Animal::factory(), // Usa uno existente o crea nuevo
            'treatment_type' => fake()->randomElement([
                'vaccination',
                'deworming',
                'surgery',
                'check-up',
                'neutering',
            ]),
            'treatment_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'description' => fake()->sentence(8),
            'observations' => fake()->boolean(60) ? fake()->sentence(10) : null, // 60% con observaciones
        ];
    }
}

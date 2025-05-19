<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adoption>
 */
class AdoptionFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adoptionDate = fake()->dateTimeBetween('-1 years', 'now');

        return [
            'animal_id' => Animal::inRandomOrder()->first()?->id ?? Animal::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'adoption_date' => $adoptionDate->format('Y-m-d'),
            'notes' => fake()->boolean(40) ? fake()->paragraph() : null,
        ];
    }
}

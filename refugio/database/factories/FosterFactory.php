<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Foster>
 */
class FosterFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'fostering', 'finished']);
        $startDate = fake()->dateTimeBetween('-3 months', 'now');
        $hasEnded = $status === 'finished';

        return [
            'animal_id' => Animal::inRandomOrder()->first()?->id ?? Animal::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $hasEnded ? fake()->dateTimeBetween($startDate, 'now')->format('Y-m-d') : null,
            'status' => $status,
            'comments' => fake()->boolean(50) ? fake()->sentence(12) : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsorship>
 */
class SponsorshipFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-2 years', 'now');
        $endDate = fake()->boolean(50) ? fake()->dateTimeBetween($startDate, 'now') : null;
        $statuses = ['active', 'paused', 'cancelled', 'completed'];

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'animal_id' => Animal::inRandomOrder()->first()?->id ?? Animal::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'status' => fake()->randomElement($statuses),
            'notes' => fake()->boolean(30) ? fake()->paragraph() : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'reviewed', 'archived']);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->boolean(60) ? fake()->phoneNumber() : null,
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraph(3),
            'status' => $status,
            'admin_notes' => fake()->boolean(30) ? fake()->sentence(8) : null,
        ];
    }
}

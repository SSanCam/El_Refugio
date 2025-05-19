<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteerRequest>
 */
class VolunteerRequestFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'reviewed', 'accepted', 'rejected']);

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->boolean(60) ? fake()->phoneNumber() : null,
            'availability' => fake()->randomElement([
                'Weekdays mornings',
                'Weekdays afternoons',
                'Weekends',
                'Flexible',
            ]),
            'motivation' => fake()->paragraph(3),
            'status' => $status,
            'admin_notes' => fake()->boolean(30) ? fake()->sentence(10) : null,
        ];
    }
}

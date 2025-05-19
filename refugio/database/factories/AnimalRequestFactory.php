<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnimalRequest>
 */
class AnimalRequestFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['adoption', 'foster']);
        $status = fake()->randomElement(['pending', 'approved', 'rejected', 'canceled']);

        return [
            'type' => $type,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->boolean(60) ? fake()->phoneNumber() : null,
            'address' => fake()->address(),
            'message' => fake()->paragraph(2),
            'animal_id' => Animal::inRandomOrder()->first()?->id ?? Animal::factory(),
            'status' => $status,
            'admin_notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }

    /**
     * Estado específico para solicitudes de adopción.
     */
    public function adoption(): static
    {
        return $this->state(fn () => ['type' => 'adoption']);
    }

    /**
     * Estado específico para solicitudes de acogida.
     */
    public function foster(): static
    {
        return $this->state(fn () => ['type' => 'foster']);
    }
}

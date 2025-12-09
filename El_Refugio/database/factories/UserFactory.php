<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->firstName(),
            'last_name'   => $this->faker->lastName(),
            'email'       => $this->faker->unique()->safeEmail(),
            'password'    => bcrypt('password'), // password genérica
            'role'        => 'user',
            'national_id' => $this->faker->optional()->numerify('########?'),
            'phone'       => $this->faker->optional()->numerify('6########'),
            'address'     => $this->faker->optional()->streetAddress(),
            'is_active'   => true,
            'profile_picture' => null,
            'remember_token'  => Str::random(10),
        ];
    }

    /**
     * Estado: usuario administrador
     */
    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => 'admin',
        ]);
    }

    /**
     * Usuario inactivo
     */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}

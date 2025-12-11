<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->firstName(),
            'last_name'   => fake()->lastName(),
            'email'       => fake()->unique()->safeEmail(),
            'password'    => bcrypt('password'),
            'role'        => 'user',
            'national_id' => fake()->optional()->numerify('#########'),
            'phone'       => fake()->optional()->numerify('6########'),
            'address'     => fake()->optional()->streetAddress(),
            'is_active'   => true,
            'profile_picture' => null,
            'remember_token'  => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => 'admin',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Foster;
use Illuminate\Database\Eloquent\Factories\Factory;

class FosterFactory extends Factory
{
    protected $model = Foster::class;

    /**
     * Define the model's default state.
     *
     * Igual que en AdoptionFactory:
     * - user_id y animal_id se sobreescriben en el seeder.
     */
    public function definition(): array
    {
        return [
            'user_id'   => null,
            'animal_id' => null,
            'comments'  => $this->faker->optional()->sentence(),
        ];
    }
}

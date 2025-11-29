<?php

namespace Database\Factories;

use App\Models\Adoption;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdoptionFactory extends Factory
{
    protected $model = Adoption::class;

    /**
     * Define the model's default state.
     *
     * OJO:
     * - Dejamos user_id y animal_id en null para que SIEMPRE se sobreescriban
     *   desde el seeder.
     * - Solo rellenamos comments de forma opcional.
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

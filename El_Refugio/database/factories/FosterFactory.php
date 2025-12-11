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
            'comments'  =>fake()->optional()->sentence(),
        ];
    }

    /**
     * Estado con contrato adjunto
     */
    public function withContract(): static
    {
        return $this->state(fn () => [
            'contract_file' =>
                'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765296417/contr_fostered_q9royr.png',
        ]);
    }

}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Adoption;
use App\Models\User;
use App\Models\Animal;

class AdoptionFactory extends Factory
{
    protected $model = Adoption::class;

    public function definition(): array
    {
        return [
            // El seeder asignará user_id y animal_id según convenga
            'animal_id'     => Animal::factory(),
            'user_id'       => User::factory(),

            'adoption_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'contract_file' => null, // Muchos refugios no adjuntan archivo, se añade a mano
            'comments'      => $this->faker->optional()->sentence(10),
        ];
    }

    /**
     * Estado con contrato adjunto
     */
    public function withContract(): static
    {
        return $this->state(fn () => [
            'contract_file' =>
                'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765296417/contr_adopted_fq5quj.png',
        ]);
    }

}
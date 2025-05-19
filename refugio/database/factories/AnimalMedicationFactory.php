<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnimalMedication>
 */
class AnimalMedicationFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', 'now');
        $hasEndDate = fake()->boolean(70); // 70% de tratamientos con fecha de fin

        return [
            'animal_id' => Animal::inRandomOrder()->first()?->id ?? Animal::factory(),
            'medication' => fake()->randomElement([
                'Amoxicillin', 'Prednisone', 'Furosemide', 'Metronidazole', 'Ivermectin',
            ]),
            'dosage' => fake()->randomElement([
                '5 mg', '10 mg', '1 tablet', '0.5 ml', '1 injection',
            ]),
            'frequency' => fake()->randomElement([
                'once daily', 'twice daily', 'weekly', 'as needed',
            ]),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $hasEndDate ? fake()->dateTimeBetween($startDate, 'now')->format('Y-m-d') : null,
            'description' => fake()->boolean(50) ? fake()->sentence(10) : null,
        ];
    }
}

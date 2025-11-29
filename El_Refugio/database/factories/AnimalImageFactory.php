<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AnimalImage;
use App\Models\Animal;

class AnimalImageFactory extends Factory
{
    protected $model = AnimalImage::class;

    public function definition(): array
    {
        return [
            // Para tests genéricos, si no se sobreescribe
            'animal_id' => Animal::factory(),
            'url'       => $this->faker->imageUrl(
                800,
                600,
                'animals',
                true,
                'refugio'
            ),
            'alt_text'  => $this->faker->sentence(4),
        ];
    }

    /**
     * Genera una imagen provisional en función de la especie del animal.
     */
    public function forAnimal(Animal $animal): static
    {
        $category = match ($animal->species) {
            'dog' => 'dogs',
            'cat' => 'cats',
            default => 'animals',
        };

        $tipo = match ($animal->species) {
            'dog' => 'perro',
            'cat' => 'gato',
            default => 'animal',
        };

        return $this->for($animal)->state(function () use ($animal, $category, $tipo) {
            return [
                'url'      => $this->faker->imageUrl(
                    800,
                    600,
                    $category,   // dogs / cats / animals
                    true,
                    'refugio'
                ),
                'alt_text' => "Imagen provisional de {$animal->name}, {$tipo} en el refugio",
            ];
        });
    }
}

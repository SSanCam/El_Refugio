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
            'animal_id' => Animal::factory(),
            'url'       => fake()->imageUrl(800, 600, 'animals', true, 'refugio'),
            'alt_text'  => fake()->sentence(4),
        ];
    }

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
                'url'      => fake()->imageUrl(800, 600, $category, true, 'refugio'),
                'alt_text' => "Imagen provisional de {$animal->name}, {$tipo} en el refugio",
            ];
        });
    }
}

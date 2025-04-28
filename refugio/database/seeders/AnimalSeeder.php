<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Animales disponibles para adopción (4 perros y 3 gatos)
        Animal::create([
            'name' => 'Rex',
            'species' => 'Dog',
            'breed' => 'German Shepherd',
            'age' => 3,
            'sex' => 'Male',
            'size' => 'Large',
            'weight' => 30,
            'status' => 'Available for Adoption',
            'microchip' => '123456789012',
            'images' => 'rex1.jpg, rex2.jpg',
        ]);

        Animal::create([
            'name' => 'Bella',
            'species' => 'Cat',
            'breed' => 'Persian',
            'age' => 2,
            'sex' => 'Female',
            'size' => 'Small',
            'weight' => 5,
            'status' => 'Available for Adoption',
            'microchip' => '987654321098',
            'images' => 'bella1.jpg, bella2.jpg',
        ]);

        Animal::create([
            'name' => 'Max',
            'species' => 'Dog',
            'breed' => 'Golden Retriever',
            'age' => 4,
            'sex' => 'Male',
            'size' => 'Medium',
            'weight' => 25,
            'status' => 'Available for Adoption',
            'microchip' => '234567890123',
            'images' => 'max1.jpg, max2.jpg',
        ]);

        Animal::create([
            'name' => 'Luna',
            'species' => 'Cat',
            'breed' => 'Siamese',
            'age' => 1,
            'sex' => 'Female',
            'size' => 'Small',
            'weight' => 4,
            'status' => 'Available for Adoption',
            'microchip' => '112233445566',
            'images' => 'luna1.jpg, luna2.jpg',
        ]);

        // Animales adoptados (2 perros)
        Animal::create([
            'name' => 'Rocky',
            'species' => 'Dog',
            'breed' => 'Bulldog',
            'age' => 2,
            'sex' => 'Male',
            'size' => 'Medium',
            'weight' => 20,
            'status' => 'Adopted',
            'microchip' => '332211445566',
            'images' => 'rocky1.jpg, rocky2.jpg',
        ]);

        Animal::create([
            'name' => 'Milo',
            'species' => 'Dog',
            'breed' => 'Poodle',
            'age' => 3,
            'sex' => 'Male',
            'size' => 'Small',
            'weight' => 7,
            'status' => 'Adopted',
            'microchip' => '667788990011',
            'images' => 'milo1.jpg, milo2.jpg',
        ]);

        // Animales en acogida (2 gatos)
        Animal::create([
            'name' => 'Whiskers',
            'species' => 'Cat',
            'breed' => 'Maine Coon',
            'age' => 2,
            'sex' => 'Female',
            'size' => 'Large',
            'weight' => 8,
            'status' => 'In Foster Care',
            'microchip' => '556677889900',
            'images' => 'whiskers1.jpg, whiskers2.jpg',
        ]);

        Animal::create([
            'name' => 'Shadow',
            'species' => 'Cat',
            'breed' => 'Bengal',
            'age' => 4,
            'sex' => 'Male',
            'size' => 'Medium',
            'weight' => 6,
            'status' => 'In Foster Care',
            'microchip' => '998877665544',
            'images' => 'shadow1.jpg, shadow2.jpg',
        ]);

        // Animales en el refugio (2 animales no adoptados ni acogidos)
        Animal::create([
            'name' => 'Buddy',
            'species' => 'Dog',
            'breed' => 'Labrador',
            'age' => 2,
            'sex' => 'Male',
            'size' => 'Large',
            'weight' => 30,
            'status' => 'In Shelter',
            'microchip' => '001122334455',
            'images' => 'buddy1.jpg, buddy2.jpg',
        ]);

        Animal::create([
            'name' => 'Sasha',
            'species' => 'Cat',
            'breed' => 'Burmese',
            'age' => 3,
            'sex' => 'Female',
            'size' => 'Medium',
            'weight' => 5,
            'status' => 'In Shelter',
            'microchip' => '223344556677',
            'images' => 'sasha1.jpg, sasha2.jpg',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuarios adoptantes
        User::create([
            'name' => 'Adoptante Uno',
            'email' => 'adoptante1@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600111111',
            'address' => 'Calle Adopción 1',
        ]);

        User::create([
            'name' => 'Adoptante Dos',
            'email' => 'adoptante2@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600222222',
            'address' => 'Calle Adopción 2',
        ]);

        User::create([
            'name' => 'Adoptante Tres',
            'email' => 'adoptante3@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600333333',
            'address' => 'Calle Adopción 3',
        ]);

        User::create([
            'name' => 'Adoptante Cuatro',
            'email' => 'adoptante4@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600444444',
            'address' => 'Calle Adopción 4',
        ]);

        // Usuarios acogedores
        User::create([
            'name' => 'Acogedor Uno',
            'email' => 'acogedor1@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600555555',
            'address' => 'Calle Acogida 1',
        ]);

        User::create([
            'name' => 'Acogedor Dos',
            'email' => 'acogedor2@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600666666',
            'address' => 'Calle Acogida 2',
        ]);

        // Usuario que adopta y acoge
        User::create([
            'name' => 'Adopta y Acoge',
            'email' => 'adoptaacoge@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600777777',
            'address' => 'Calle Mixta 1',
        ]);

        // Usuario solo voluntario
        User::create([
            'name' => 'Voluntario Uno',
            'email' => 'voluntario1@example.com',
            'password' => bcrypt('password123'),
            'phone' => '600888888',
            'address' => 'Calle Voluntariado 1',
        ]);

        // Usuarios solo registrados (mínimos)
        User::create([
            'name' => 'Registrado Básico Uno',
            'email' => 'basico1@example.com',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'Registrado Básico Dos',
            'email' => 'basico2@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}

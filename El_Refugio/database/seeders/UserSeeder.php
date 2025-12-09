<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ---------------------------------------------------------
        // 1) USUARIO ADMIN PRINCIPAL
        // ---------------------------------------------------------
        User::create([
            'name'        => 'Admin',
            'last_name'   => 'Principal',
            'email'       => 'admin@refugio.test',
            'password'    => Hash::make('password'),
            'role'        => 'admin',
            'national_id' => null,
            'phone'       => null,
            'address'     => 'Refugio Central',
            'is_active'   => true,
            'profile_picture' => null,
        ]);

        // ---------------------------------------------------------
        // 2) USUARIO NORMAL DE PRUEBA
        // ---------------------------------------------------------
        User::create([
            'name'        => 'Usuario',
            'last_name'   => 'Demo',
            'email'       => 'usuario@refugio.test',
            'password'    => Hash::make('password'),
            'role'        => 'user',
            'national_id' => null,
            'phone'       => null,
            'address'     => 'Calle Ejemplo 123',
            'is_active'   => true,
            'profile_picture' => null,
        ]);

        // ---------------------------------------------------------
        // 3) 18 USUARIOS FAKER
        // ---------------------------------------------------------
        User::factory(18)->create();
    }
}

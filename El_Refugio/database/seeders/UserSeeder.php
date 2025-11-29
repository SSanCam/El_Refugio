<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ─────────────────────────────────────
        //  ADMINISTRADORES (con acceso web)
        // ─────────────────────────────────────

        User::factory()->create([
            'name'              => 'Admin',
            'last_name'         => 'Principal',
            'email'             => 'admin@refugio.test',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'name'              => 'Admin',
            'last_name'         => 'Adopciones',
            'email'             => 'adopciones@refugio.test',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // ─────────────────────────────────────
        //  USUARIO SIN REGISTRO WEB (adopción en oficina)
        // ─────────────────────────────────────
        // Persona que ha adoptado pero NO tiene cuenta activa en la web.
        // is_active = false simula "sin acceso web (de momento)".
        User::factory()->create([
            'name'              => 'Ana',
            'last_name'         => 'Oficina',
            'email'             => 'adoptante.oficina@ejemplo.test',
            'role'              => 'user',
            'is_active'         => false,
            'email_verified_at' => null,
        ]);

        // ─────────────────────────────────────
        //  USUARIOS NORMALES (CON REGISTRO WEB)
        // ─────────────────────────────────────

        // 1) Solo registro web (sin adopciones ni acogidas)
        User::factory()->create([
            'name'              => 'Lucía',
            'last_name'         => 'Visitante',
            'email'             => 'lucia.visitante@ejemplo.test',
            'role'              => 'user',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // 2) Registro web + ADOPCIÓN
        User::factory()->create([
            'name'              => 'Carlos',
            'last_name'         => 'Adoptante',
            'email'             => 'carlos.adoptante@ejemplo.test',
            'role'              => 'user',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // 3) Registro web + ADOPCIÓN + ACOGIDA
        User::factory()->create([
            'name'              => 'Marta',
            'last_name'         => 'Acogida',
            'email'             => 'marta.acogida@ejemplo.test',
            'role'              => 'user',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
    }
}

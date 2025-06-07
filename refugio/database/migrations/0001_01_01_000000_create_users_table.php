<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear las tablas relacionadas con usuarios.
     */
    public function up(): void
    {
        // Tabla principal de usuarios registrados en el sistema.
        // Incluye campos básicos como nombre, email, contraseña, teléfono y dirección.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dni')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');            
            $table->string('phone')->nullable()->unique(); 
            $table->string('address')->nullable(); 
            $table->date('birthdate')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_code')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabla utilizada para almacenar tokens temporales
        // durante el proceso de recuperación de contraseña.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabla que almacena la información de las sesiones activas de los usuarios
        // si se utiliza SESSION_DRIVER=database en el archivo .env.
        // Incluye datos como la IP, el navegador y el contenido de la sesión serializado.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Revierte la migración eliminando las tablas relacionadas con usuarios.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
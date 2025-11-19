<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/**
 * Tabla de User 
 * Crea la tabla de usuarios con campos esenciales para autenticación y perfil completo.
 * Al usuario registrado, terminará de completar sus datos el personal administrativo si se finaliza con éxito formularios de adopción o acogida.
 * Esto permite un equilibrio entre la facilidad de registro y la necesidad de información detallada para la gestión del refugio.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('national_id')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->string('profile_picture')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        /**
         * Tabla de tokens para restablecimiento de contraseñas
         */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        /**
         * Tabla de sesiones para seguimiento de usuarios
         */
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
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
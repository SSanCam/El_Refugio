<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla de solicitudes de animales.
     */
    public function up(): void
    {
        Schema::create('animal_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->foreignId('animal_id')->nullable()->constrained('animals');
            $table->text('message');
            $table->string('status');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla de solicitudes de animales.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_requests');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla de animales.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->string('breed')->nullable();
            $table->integer('age');
            $table->string('sex');
            $table->string('size');
            $table->float('weight')->nullable();
            $table->string('status');
            $table->string('microchip')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla de animales.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};

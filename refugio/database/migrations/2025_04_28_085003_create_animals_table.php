<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'animals'.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->string('breed')->nullable();
            $table->integer('age');
            $table->enum('size', ['small', 'medium', 'large']);
            $table->enum('sex', ['male', 'female', 'unknown']);
            $table->float('weight')->nullable();
            $table->enum('status', ['available', 'adopted', 'fostered', 'sponsored', 'sheltered', 'intake', 'deceased']);
            $table->string('microchip')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla 'animals'.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'fosters'.
     */
    public function up(): void
    {
        Schema::create('fosters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('user_id')->constrained('users');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['pending', 'fostering', 'finished']);
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla 'fosters'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fosters');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'veterinary_histories'.
     */
    public function up(): void
    {
        Schema::create('veterinary_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals');
            $table->string('treatment_type');
            $table->date('treatment_date');
            $table->text('description');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla 'veterinary_histories'.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinary_histories');
    }
};

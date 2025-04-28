<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id(); // ID primario del animal
            $table->string('name'); // Nombre del animal
            $table->string('species'); // Especie (ej: perro, gato)
            $table->string('breed')->nullable(); // Raza (opcional)
            $table->integer('age'); // Edad aproximada
            $table->string('sex'); // Sexo biológico
            $table->string('size'); // Tamaño (pequeño, mediano, grande)
            $table->float('weight')->nullable(); // Peso (opcional)
            $table->string('status'); // Estado (available, fostered, adopted)
            $table->string('microchip')->nullable(); // Número de microchip (opcional)
            $table->text('description')->nullable(); // Descripción detallada (opcional)
            $table->string('image')->nullable(); // Imagen principal (opcional)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};

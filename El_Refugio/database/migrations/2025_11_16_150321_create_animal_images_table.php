<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/**
 * Tabla de Animal_Images
 * Crea la tabla de imágenes asociadas a los animales en el refugio.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animal_images', function (Blueprint $table) {
            $table->id();
            
            // Relación con animals
            $table->foreignId('animal_id')
                ->constrained('animals')
                ->onDelete('cascade');

            // Datos de la imagen
            $table->string('url');
            $table->string('alt_text')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_images');
    }
};

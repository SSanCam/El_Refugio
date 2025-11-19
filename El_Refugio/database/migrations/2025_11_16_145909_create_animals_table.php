<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/** 
 * Tabla de Animals
 * Crea la tabla de animales con campos detallados para su gestión en el refugio
 * Los campos nullables, permiten flexibilidad en la información disponible inmediata, con la opción de completar datos posteriormente.
 * Esto hace que, aunque haya datos incompletos al momento del ingreso, el sistema pueda seguir funcionando eficientemente.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('species', ['dog', 'cat', 'other']);
            $table->string('breed')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->enum('size', ['small', 'medium', 'large'])->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->boolean('neutered')->default(false);
            $table->string('microchip')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('status', ['sheltered','fostered','adopted','deceased'])->default('sheltered');
            $table->enum('availability', ['available','unavailable'])->default('unavailable');
            $table->date('entry_date');
            $table->text('description')->nullable();
            $table->text('observations')->nullable(); 
            $table->boolean('is_featured')->default(false);

            $table->timestamp('featured_at')->nullable();
            $table->timestamps();
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
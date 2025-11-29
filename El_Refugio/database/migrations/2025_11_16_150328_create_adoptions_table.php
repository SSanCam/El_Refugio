<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
/**
 * Tabla de Adoptions
 * Crea la tabla de adopciones para registrar las adopciones de animales en el refugio.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('animal_id')
                ->constrained('animals')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Datos de la adopción
            $table->date('adoption_date')->default(DB::raw('CURRENT_DATE'));
            $table->string('contract_file')->nullable();
            $table->text('comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};

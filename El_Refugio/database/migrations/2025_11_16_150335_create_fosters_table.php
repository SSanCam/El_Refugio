<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
/**
 * Tabla de Fosters
 * Crea la tabla de acogidas para registrar las acogidas de animales en el refugio.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fosters', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('animal_id')
                ->constrained('animals')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Datos de la acogida
            $table->timestamp('start_date')->useCurrent();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('fosters');
    }
};

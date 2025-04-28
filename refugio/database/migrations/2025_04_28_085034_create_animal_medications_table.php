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
        Schema::create('animal_medications', function (Blueprint $table) {
            $table->id(); // ID primario del tratamiento
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade'); // Animal asociado
            $table->string('medication'); // Nombre del medicamento
            $table->string('dosage'); // Dosis administrada
            $table->string('frequency'); // Frecuencia del tratamiento (diaria, semanal, etc.)
            $table->date('start_date'); // Fecha de inicio
            $table->date('end_date')->nullable(); // Fecha de finalización (opcional)
            $table->text('description')->nullable(); // Descripción adicional (opcional)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_medications');
    }
};

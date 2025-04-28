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
        Schema::create('veterinary_histories', function (Blueprint $table) {
            $table->id(); // ID primario del evento médico
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade'); // Animal asociado
            $table->string('treatment_type'); // Tipo de tratamiento (vacunación, cirugía, etc.)
            $table->date('treatment_date'); // Fecha del tratamiento
            $table->text('description'); // Descripción detallada del tratamiento
            $table->text('observations')->nullable(); // Observaciones adicionales (opcional)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinary_histories');
    }
};

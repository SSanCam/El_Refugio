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
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id(); // ID primario de la adopción
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade'); // Animal adoptado
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario adoptante
            $table->date('adoption_date'); // Fecha de formalización de adopción
            $table->text('notes')->nullable(); // Notas internas (opcional)
            $table->timestamps(); // created_at y updated_at
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

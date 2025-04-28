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
        Schema::create('fosters', function (Blueprint $table) {
            $table->id(); // ID primario de la acogida
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade'); // Animal acogido
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario acogedor
            $table->date('start_date'); // Fecha de inicio de acogida
            $table->date('end_date')->nullable(); // Fecha de finalización (opcional)
            $table->string('status'); // Estado de la acogida (pending, fostering, finished)
            $table->text('comments')->nullable(); // Comentarios internos (opcional)
            $table->timestamps(); // created_at y updated_at
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

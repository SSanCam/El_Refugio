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
        Schema::create('volunteer_requests', function (Blueprint $table) {
            $table->id(); // ID primario de la solicitud de voluntariado
            $table->string('first_name'); // Nombre del solicitante
            $table->string('last_name'); // Apellidos del solicitante
            $table->string('email'); // Correo electrónico
            $table->string('phone')->nullable(); // Teléfono (opcional)
            $table->string('availability'); // Disponibilidad horaria
            $table->text('motivation'); // Motivación para ser voluntario
            $table->string('status'); // Estado de la solicitud (pending, reviewed, accepted, rejected)
            $table->text('admin_notes')->nullable(); // Notas internas (opcional)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_requests');
    }
};

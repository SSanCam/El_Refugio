<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'animal_requests'.
     */
    public function up(): void
    {
        Schema::create('animal_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Tipo de solicitud: 'adoption' o 'foster'
            $table->enum('type', ['adoption', 'foster']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->foreignId('animal_id')->nullable()->constrained('animals');
            $table->text('message');
            $table->string('status');
            $table->foreignId('animal_id')->nullable()->constrained('animals')->nullOnDelete();
            $table->text('message');
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected']);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla 'animal_requests'.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_requests');
    }
};

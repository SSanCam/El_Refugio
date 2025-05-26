<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla de apadrinamientos.
     */
    public function up(): void
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('animal_id')->constrained('animals');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status');
            $table->decimal('donation_amount', 8, 2)->default(0); 
            $table->string('donation_interval')->default('único'); 
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla de apadrinamientos.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorships');
    }
};

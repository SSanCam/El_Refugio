<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'volunteer_requests'.
     */
    public function up(): void
    {
        Schema::create('volunteer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('availability');
            $table->text('motivation');
            $table->string('status');
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected']);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla 'volunteer_requests'.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_requests');
    }
};

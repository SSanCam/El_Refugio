<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla de mensajes de contacto.
     */
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['pending', 'reviewed', 'archived']);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla de mensajes de contacto.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};

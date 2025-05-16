<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'contact_requests'.
     */
    public function up(): void
    {
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('status');
            $table->enum('status', ['pending', 'reviewed', 'archived']);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla 'contact_requests'.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};

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
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id(); // ID primario del mensaje de contacto
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Usuario registrado (opcional)
            $table->string('email'); // Correo electrónico de contacto
            $table->string('phone')->nullable(); // Teléfono (opcional)
            $table->string('subject'); // Asunto del mensaje
            $table->text('message'); // Contenido del mensaje
            $table->string('status'); // Estado del mensaje (pending, reviewed, archived)
            $table->text('admin_notes')->nullable(); // Notas internas (opcional)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};

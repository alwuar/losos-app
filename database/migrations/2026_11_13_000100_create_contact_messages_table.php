<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cada formulario de contacto se guarda aquí antes de mandarse a Nerby:
        // si Nerby no responde, el mensaje no se pierde y se reintenta después.
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email', 150);
            $table->string('phone', 40);
            $table->string('company', 150)->nullable();
            $table->string('equipment', 100)->nullable();
            $table->string('page_url', 300)->nullable();
            $table->timestamp('nerby_sent_at')->nullable();
            $table->unsignedSmallInteger('nerby_attempts')->default(0);
            $table->string('nerby_error', 300)->nullable();
            $table->timestamps();

            $table->index(['nerby_sent_at', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};

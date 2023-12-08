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
        Schema::create('reservas', function (Blueprint $table) {
            $table->foreignId('id_alumno')->references('id')->on('alumnos')->constrained()->onDelete('cascade')->change();
            $table->foreignId('id_horario')->references('id')->on('horarios')->constrained()->onDelete('cascade')->change();
            $table->unique(['id_alumno', 'id_horario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

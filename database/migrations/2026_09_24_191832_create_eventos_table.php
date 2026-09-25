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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('id_evento');
            $table->unsignedBigInteger('id_dispositivo');
            $table->string('tipo_evento'); // movimiento, apertura, error, etc
            $table->string('nivel'); // info, warning, critical
            $table->dateTime('fecha_hora');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('id_dispositivo')->references('id_dispositivo')->on('dispositivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

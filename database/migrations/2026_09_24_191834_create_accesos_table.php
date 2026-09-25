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
        Schema::create('accesos', function (Blueprint $table) {
            $table->id('id_acceso');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_dispositivo');
            $table->string('metodo'); // pin, rfid, app
            $table->string('resultado'); // exito, denegado
            $table->dateTime('fecha_hora');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_dispositivo')->references('id_dispositivo')->on('dispositivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesos');
    }
};

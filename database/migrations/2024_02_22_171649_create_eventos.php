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
            $table->uuid('id')->primary();
            $table->uuid('usuario_idUsuario')->nullable(true)->default(null);
            $table->foreign('usuario_idUsuario')->references('id')->on('usuarios');


            $table->string('titulo', 200)->nullable(true)->default(null);
            $table->string('descricao', 1000)->nullable(true)->default(null);
            $table->string('status', 20)->nullable(true)->default(null);

            $table->date('data_inicio')->nullable(true)->default(null);
            $table->time('hora_inicio')->nullable(true)->default(null);
            $table->date('data_termino')->nullable(true)->default(null);
            $table->time('hora_termino')->nullable(true)->default(null);
            $table->string('localidade')->nullable(true)->default(null);

            $table->dateTime('created_at')->nullable(true)->default(null);
            $table->dateTime('updated_at')->nullable(true)->default(null);
            $table->dateTime('deleted_at')->nullable(true)->default(null);
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

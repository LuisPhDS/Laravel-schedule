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
        Schema::create('contatos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('usuario_idUsuario')->nullable(true)->default(null);
            $table->foreign('usuario_idUsuario')->references('id')->on('usuarios');

            
            $table->string('nome', 65)->nullable(true)->default(null);
            $table->string('telefone', 20)->nullable(true)->default(null);
            $table->string('imagem')->nullable(true)->default(null);

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
        Schema::dropIfExists('contatos');
    }
};

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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome', 45);
            $table->string('email', 65);
            $table->string('senha');

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
        Schema::dropIfExists('usuarios');
    }
};

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
        Schema::create('exercicios_ficha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_treino_id')->constrained('fichas_treino')->onDelete('cascade');
            $table->string('exercise');
            $table->string('sets');
            $table->string('repetitions');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercicios_ficha');
    }
};

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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filial_id')->constrained('filiais')->onDelete('cascade');
            $table->string('name');
            $table->date('birth_date');
            $table->string('objective'); // Ex: Hipertrofia, emagrecimento, etc.
            $table->string('experience_level'); // Ex: Iniciante, Intermediário, Avançado
            $table->text('health_conditions')->nullable(); // Comorbidades, lesões, etc.
            $table->unsignedInteger('height')->nullable(); // Altura em centímetros
            $table->decimal('weight', 5, 2)->nullable(); // Peso em kg
            $table->text('preferred_exercises')->nullable();
            $table->text('avoided_exercises')->nullable();
            $table->text('previous_training')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};

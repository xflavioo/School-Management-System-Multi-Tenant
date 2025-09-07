<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10); // A, B, C, etc.
            $table->unsignedInteger('serie_id');
            $table->unsignedInteger('turno_id');
            $table->unsignedInteger('professor_regente_id')->nullable();
            $table->string('ano_letivo', 4); // Academic year (2024, 2025, etc.)
            $table->tinyInteger('capacidade_maxima')->unsigned()->nullable(); // Max capacity
            $table->string('sala', 20)->nullable(); // Classroom number/name
            $table->boolean('active')->default(true);
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('restrict');
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('restrict');
            $table->foreign('professor_regente_id')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['serie_id', 'turno_id', 'ano_letivo']);
            $table->index(['active', 'ano_letivo']);
            
            // Unique constraint: one turma per serie/turno/year/name combination
            $table->unique(['serie_id', 'turno_id', 'ano_letivo', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turmas');
    }
}
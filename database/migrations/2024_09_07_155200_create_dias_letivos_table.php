<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiasLetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dias_letivos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('calendario_id');
            $table->date('data'); // School day date
            $table->enum('tipo_dia', ['normal', 'especial', 'suspenso', 'reposicao'])->default('normal');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Foreign key
            $table->foreign('calendario_id')->references('id')->on('calendarios_letivos')->onDelete('cascade');
            
            // Indexes
            $table->index(['calendario_id', 'data']);
            $table->index(['data', 'tipo_dia']);
            
            // Unique constraint: one record per calendar per date
            $table->unique(['calendario_id', 'data']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dias_letivos');
    }
}
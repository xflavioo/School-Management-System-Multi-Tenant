<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeriadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feriados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('calendario_id')->nullable(); // null for global holidays
            $table->string('nome'); // Holiday name
            $table->date('data'); // Holiday date
            $table->enum('tipo', ['nacional', 'estadual', 'municipal', 'escolar'])->default('nacional');
            $table->boolean('recorrente')->default(true); // If holiday repeats yearly
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Foreign key
            $table->foreign('calendario_id')->references('id')->on('calendarios_letivos')->onDelete('cascade');
            
            // Indexes
            $table->index(['data', 'tipo']);
            $table->index(['calendario_id', 'data']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feriados');
    }
}
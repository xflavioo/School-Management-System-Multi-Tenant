<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50); // Manhã, Tarde, Noite, Integral
            $table->char('codigo', 1)->unique(); // M, T, N, I
            $table->time('inicio')->nullable(); // Start time
            $table->time('fim')->nullable(); // End time
            $table->boolean('active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Index
            $table->index(['active']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnos');
    }
}
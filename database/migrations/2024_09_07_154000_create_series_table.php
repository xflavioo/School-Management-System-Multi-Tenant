<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100); // e.g., "1º Ano", "2º Ano", etc.
            $table->enum('nivel_ensino', ['fundamental', 'medio']); // fundamental = elementary, medio = high school
            $table->tinyInteger('order')->unsigned(); // 1-9 for fundamental, 1-3 for medio
            $table->boolean('active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['nivel_ensino', 'order']);
            $table->unique(['nivel_ensino', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
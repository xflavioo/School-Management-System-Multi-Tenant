<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendariosLetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarios_letivos', function (Blueprint $table) {
            $table->increments('id');
            $table->year('ano'); // Academic year (2024, 2025, etc.)
            $table->date('inicio'); // Start date of academic year
            $table->date('fim'); // End date of academic year
            $table->smallInteger('dias_letivos_minimos')->default(200); // Minimum required school days
            $table->boolean('active')->default(true);
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['ano', 'active']);
            $table->unique(['ano']); // Only one calendar per year
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendarios_letivos');
    }
}
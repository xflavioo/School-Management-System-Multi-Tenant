<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrazilianSchoolFieldsToStudentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_records', function (Blueprint $table) {
            // Add Brazilian school structure fields
            $table->unsignedInteger('serie_id')->nullable()->after('section_id');
            $table->unsignedInteger('turno_id')->nullable()->after('serie_id');
            $table->unsignedInteger('turma_id')->nullable()->after('turno_id');
            
            // Foreign keys
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('set null');
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('set null');
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('set null');
            
            // Index for better performance
            $table->index(['serie_id', 'turma_id', 'session']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropForeign(['serie_id']);
            $table->dropForeign(['turno_id']);
            $table->dropForeign(['turma_id']);
            $table->dropIndex(['serie_id', 'turma_id', 'session']);
            
            $table->dropColumn(['serie_id', 'turno_id', 'turma_id']);
        });
    }
}
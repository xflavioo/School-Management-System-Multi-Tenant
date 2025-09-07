<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrazilianFieldsToStudentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_records', function (Blueprint $table) {
            // Add a field to track if the student has withdrawn (wd)
            $table->boolean('wd')->default(false)->after('grad_date');
            $table->date('wd_date')->nullable()->after('wd');
            
            // Brazilian school-specific fields
            $table->string('enrollment_type', 50)->nullable()->after('adm_no'); // tipo de matrícula
            $table->string('transport_type', 50)->nullable()->after('enrollment_type'); // transporte escolar
            $table->boolean('has_special_needs')->default(false)->after('transport_type');
            $table->text('special_needs_description')->nullable()->after('has_special_needs');
            
            // Emergency contact (besides parent)
            $table->string('emergency_contact_name')->nullable()->after('special_needs_description');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_relationship')->nullable()->after('emergency_contact_phone');
            
            // Additional documents for Brazilian students
            $table->boolean('has_birth_certificate')->default(false)->after('emergency_contact_relationship');
            $table->boolean('has_vaccination_card')->default(false)->after('has_birth_certificate');
            $table->boolean('has_medical_certificate')->default(false)->after('has_vaccination_card');
            $table->boolean('has_transfer_certificate')->default(false)->after('has_medical_certificate');
            
            // Previous school information
            $table->string('previous_school')->nullable()->after('has_transfer_certificate');
            $table->string('previous_school_city')->nullable()->after('previous_school');
            $table->char('previous_school_state', 2)->nullable()->after('previous_school_city');
            
            // Scholarship/financial aid
            $table->boolean('has_scholarship')->default(false)->after('previous_school_state');
            $table->decimal('scholarship_percentage', 5, 2)->nullable()->after('has_scholarship');
            $table->string('scholarship_type')->nullable()->after('scholarship_percentage');
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
            $table->dropColumn([
                'wd', 'wd_date',
                'enrollment_type', 'transport_type', 'has_special_needs', 'special_needs_description',
                'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
                'has_birth_certificate', 'has_vaccination_card', 'has_medical_certificate', 'has_transfer_certificate',
                'previous_school', 'previous_school_city', 'previous_school_state',
                'has_scholarship', 'scholarship_percentage', 'scholarship_type'
            ]);
        });
    }
}
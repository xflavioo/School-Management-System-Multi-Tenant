<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrazilianFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Brazilian personal documents
            $table->string('cpf', 14)->nullable()->unique()->after('email');
            $table->string('rg', 20)->nullable()->after('cpf');
            $table->string('rg_issuer', 20)->nullable()->after('rg');
            $table->char('rg_state', 2)->nullable()->after('rg_issuer');
            $table->date('rg_issue_date')->nullable()->after('rg_state');
            
            // Brazilian address fields
            $table->char('cep', 8)->nullable()->index()->after('address');
            $table->string('street')->nullable()->after('cep');
            $table->string('number', 15)->nullable()->after('street');
            $table->string('complement')->nullable()->after('number');
            $table->string('neighborhood')->nullable()->after('complement');
            $table->string('city')->nullable()->after('neighborhood');
            $table->char('uf', 2)->nullable()->after('city');
            
            // Brazilian phone fields with area codes
            $table->string('phone_mobile', 16)->nullable()->after('phone2');
            $table->string('phone_home', 16)->nullable()->after('phone_mobile');
            
            // Additional Brazilian fields
            $table->string('social_name')->nullable()->after('name');
            $table->string('birth_certificate')->nullable()->after('social_name');
            $table->string('vaccination_card')->nullable()->after('birth_certificate');
            $table->string('sus_card')->nullable()->after('vaccination_card'); // SUS card number
            $table->string('nis')->nullable()->after('sus_card'); // NIS/PIS/PASEP
            
            // Index for better performance on searches
            $table->index(['cpf']);
            $table->index(['uf', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['cpf']);
            $table->dropIndex(['uf', 'city']);
            
            $table->dropColumn([
                'cpf', 'rg', 'rg_issuer', 'rg_state', 'rg_issue_date',
                'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'uf',
                'phone_mobile', 'phone_home',
                'social_name', 'birth_certificate', 'vaccination_card', 'sus_card', 'nis'
            ]);
        });
    }
}
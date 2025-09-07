<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_types')->delete();

        $data = [
            ['name' => 'Creche', 'code' => 'CR'],
            ['name' => 'Pré-Escola', 'code' => 'PE'],
            ['name' => 'Maternal', 'code' => 'MT'],
            ['name' => 'Ensino Fundamental', 'code' => 'EF'],
            ['name' => 'Ensino Fundamental II', 'code' => 'EF2'],
            ['name' => 'Ensino Médio', 'code' => 'EM'],
            ['name' => 'Ensino Médio II', 'code' => 'EM2'],            
        ];

        DB::table('class_types')->insert($data);

    }
}

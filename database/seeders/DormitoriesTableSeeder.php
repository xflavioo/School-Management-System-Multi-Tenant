<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DormitoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dormitories')->delete();
        $data = [
            ['name' => 'Alojamento Fé'],
            ['name' => 'Alojamento Paz'],
            ['name' => 'Alojamento Graça'],
            ['name' => 'Alojamento Sucesso'],
            ['name' => 'Alojamento Confiança'],
        ];
        DB::table('dormitories')->insert($data);
    }
}

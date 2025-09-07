<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dorms')->delete();
        $data = [
            ['name' => 'Alojamento Fé'],
            ['name' => 'Alojamento Paz'],
            ['name' => 'Alojamento Graça'],
            ['name' => 'Alojamento Sucesso'],
            ['name' => 'Alojamento Confiança'],
        ];
        DB::table('dorms')->insert($data);
    }
}

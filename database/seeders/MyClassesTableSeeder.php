<?php
namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MyClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('my_classes')->delete();
        $ct = ClassType::pluck('id')->all();

        $data = [
            ['name' => 'Maternal 1', 'class_type_id' => $ct[2]],
            ['name' => 'Maternal 2', 'class_type_id' => $ct[2]],
            ['name' => 'Maternal 3', 'class_type_id' => $ct[2]],
            ['name' => '1º Ano', 'class_type_id' => $ct[3]],
            ['name' => '2º Ano', 'class_type_id' => $ct[3]],
            ['name' => '7º Ano', 'class_type_id' => $ct[4]],
            ['name' => '8º Ano', 'class_type_id' => $ct[4]],
            ['name' => '1º Ano EM', 'class_type_id' => $ct[5]],
            ['name' => '2º Ano EM', 'class_type_id' => $ct[5]],
            ['name' => '3º Ano EM', 'class_type_id' => $ct[5]],
            ];

        DB::table('my_classes')->insert($data);

    }
}

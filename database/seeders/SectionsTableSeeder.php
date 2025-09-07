<?php
namespace Database\Seeders;

use App\Models\MyClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();
        $c = MyClass::pluck('id')->all();

        $data = [
            ['name' => 'Ouro', 'my_class_id' => $c[0], 'active' => 1],
            ['name' => 'Diamante', 'my_class_id' => $c[0], 'active' => 0],
            ['name' => 'Prata', 'my_class_id' => $c[1], 'active' => 1],
            ['name' => 'Limão', 'my_class_id' => $c[1], 'active' => 0],
            ['name' => 'Bronze', 'my_class_id' => $c[2], 'active' => 1],
            ['name' => 'Prata', 'my_class_id' => $c[3], 'active' => 1],
            ['name' => 'Diamante', 'my_class_id' => $c[4], 'active' => 1],
            ['name' => 'Azul', 'my_class_id' => $c[5], 'active' => 1],
            ['name' => 'A', 'my_class_id' => $c[6], 'active' => 1],
            ['name' => 'A', 'my_class_id' => $c[7], 'active' => 1],
            ['name' => 'A', 'my_class_id' => $c[8], 'active' => 1],
            ['name' => 'A', 'my_class_id' => $c[9], 'active' => 1],
        ];

        DB::table('sections')->insert($data);
    }
}

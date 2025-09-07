<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'accountant', 'name' => 'Contador', 'level' => 5],
            ['title' => 'parent', 'name' => 'Responsável', 'level' => 4],
            ['title' => 'teacher', 'name' => 'Professor', 'level' => 3],
            ['title' => 'admin', 'name' => 'Administrador', 'level' => 2],
            ['title' => 'super_admin', 'name' => 'Super Administrador', 'level' => 1],
           // ['title' => 'librarian', 'name' => 'Bibliotecário', 'level' => 6],
        ];
        DB::table('user_types')->insert($data);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->delete();

        $this->createSkills();
    }

    protected function createSkills()
    {

        $types = ['AF', 'PS']; // Affective & Psychomotor Traits/Skills
        $d = [

            [ 'name' => 'PONTUALIDADE', 'skill_type' => $types[0] ],
            [ 'name' => 'ORGANIZAÇÃO', 'skill_type' => $types[0] ],
            [ 'name' => 'HONESTIDADE', 'skill_type' => $types[0] ],
            [ 'name' => 'CONFIABILIDADE', 'skill_type' => $types[0] ],
            [ 'name' => 'RELACIONAMENTO COM OS OUTROS', 'skill_type' => $types[0] ],
            [ 'name' => 'EDUCAÇÃO', 'skill_type' => $types[0] ],
            [ 'name' => 'ATENÇÃO', 'skill_type' => $types[0] ],
            [ 'name' => 'CALIGRAFIA', 'skill_type' => $types[1] ],
            [ 'name' => 'JOGOS E ESPORTES', 'skill_type' => $types[1] ],
            [ 'name' => 'DESENHO E ARTES', 'skill_type' => $types[1] ],
            [ 'name' => 'PINTURA', 'skill_type' => $types[1] ],
            [ 'name' => 'CONSTRUÇÃO', 'skill_type' => $types[1] ],
            [ 'name' => 'HABILIDADES MUSICAIS', 'skill_type' => $types[1] ],
            [ 'name' => 'FLEXIBILIDADE', 'skill_type' => $types[1] ],

        ];
        DB::table('skills')->insert($d);
    }

}

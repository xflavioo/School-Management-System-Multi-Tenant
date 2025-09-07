<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\Turno;
use Illuminate\Database\Seeder;

class BrazilianSchoolStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Brazilian grade levels (Series)
        $this->createSeries();
        
        // Create Brazilian shifts (Turnos)
        $this->createTurnos();
    }

    /**
     * Create Brazilian grade levels
     */
    private function createSeries()
    {
        // Ensino Fundamental (Elementary School) - 1º to 9º year
        $fundamentalSeries = [
            ['name' => '1º Ano EF', 'order' => 1],
            ['name' => '2º Ano EF', 'order' => 2],
            ['name' => '3º Ano EF', 'order' => 3],
            ['name' => '4º Ano EF', 'order' => 4],
            ['name' => '5º Ano EF', 'order' => 5],
            ['name' => '6º Ano EF', 'order' => 6],
            ['name' => '7º Ano EF', 'order' => 7],
            ['name' => '8º Ano EF', 'order' => 8],
            ['name' => '9º Ano EF', 'order' => 9],
        ];

        foreach ($fundamentalSeries as $serie) {
            Serie::create([
                'name' => $serie['name'],
                'nivel_ensino' => 'fundamental',
                'order' => $serie['order'],
                'active' => true,
                'description' => 'Ensino Fundamental - ' . $serie['name']
            ]);
        }

        // Ensino Médio (High School) - 1º to 3º year
        $medioSeries = [
            ['name' => '1º Ano EM', 'order' => 1],
            ['name' => '2º Ano EM', 'order' => 2],
            ['name' => '3º Ano EM', 'order' => 3],
        ];

        foreach ($medioSeries as $serie) {
            Serie::create([
                'name' => $serie['name'],
                'nivel_ensino' => 'medio',
                'order' => $serie['order'],
                'active' => true,
                'description' => 'Ensino Médio - ' . $serie['name']
            ]);
        }
    }

    /**
     * Create Brazilian shifts
     */
    private function createTurnos()
    {
        $turnos = [
            [
                'name' => 'Manhã',
                'codigo' => 'M',
                'inicio' => '07:00:00',
                'fim' => '12:00:00',
                'description' => 'Turno da manhã'
            ],
            [
                'name' => 'Tarde',
                'codigo' => 'T',
                'inicio' => '13:00:00',
                'fim' => '18:00:00',
                'description' => 'Turno da tarde'
            ],
            [
                'name' => 'Noite',
                'codigo' => 'N',
                'inicio' => '19:00:00',
                'fim' => '22:30:00',
                'description' => 'Turno da noite'
            ],
            [
                'name' => 'Integral',
                'codigo' => 'I',
                'inicio' => '07:00:00',
                'fim' => '17:00:00',
                'description' => 'Turno integral (tempo completo)'
            ],
        ];

        foreach ($turnos as $turno) {
            Turno::create($turno);
        }
    }
}
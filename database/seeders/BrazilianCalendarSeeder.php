<?php

namespace Database\Seeders;

use App\Models\CalendarioLetivo;
use App\Services\BrazilianCalendarService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BrazilianCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calendarService = new BrazilianCalendarService();
        
        // Create calendar for current year
        $currentYear = date('Y');
        $this->createCalendarForYear($calendarService, $currentYear);
        
        // Create calendar for next year
        $this->createCalendarForYear($calendarService, $currentYear + 1);
    }

    /**
     * Create calendar for a specific year
     *
     * @param BrazilianCalendarService $service
     * @param int $year
     */
    private function createCalendarForYear(BrazilianCalendarService $service, int $year)
    {
        // Check if calendar already exists
        if (CalendarioLetivo::where('ano', $year)->exists()) {
            return;
        }

        // Brazilian academic year typically runs from February to December
        $inicio = Carbon::create($year, 2, 1);
        $fim = Carbon::create($year, 12, 20);
        
        // Adjust dates to avoid weekends
        while ($inicio->isWeekend()) {
            $inicio->addDay();
        }
        
        while ($fim->isWeekend()) {
            $fim->subDay();
        }

        // Add school vacation periods and special holidays
        $customHolidays = $this->getSchoolSpecificHolidays($year);

        $calendario = $service->createAcademicCalendar($year, $inicio, $fim, [
            'dias_letivos_minimos' => 200,
            'active' => true,
            'observacoes' => 'Calendário letivo ' . $year . ' - Sistema de gestão escolar',
            'custom_holidays' => $customHolidays
        ]);

        echo "Calendário letivo criado para {$year}: {$calendario->id}\n";
    }

    /**
     * Get school-specific holidays and vacation periods
     *
     * @param int $year
     * @return array
     */
    private function getSchoolSpecificHolidays(int $year)
    {
        return [
            // Winter vacation (July)
            [
                'nome' => 'Férias de Inverno - Início',
                'data' => "$year-07-01",
                'tipo' => 'escolar',
                'recorrente' => true,
                'observacoes' => 'Início das férias de inverno'
            ],
            [
                'nome' => 'Férias de Inverno - Fim',
                'data' => "$year-07-31",
                'tipo' => 'escolar',
                'recorrente' => true,
                'observacoes' => 'Fim das férias de inverno'
            ],
            // December vacation
            [
                'nome' => 'Férias de Verão - Início',
                'data' => "$year-12-21",
                'tipo' => 'escolar',
                'recorrente' => true,
                'observacoes' => 'Início das férias de verão'
            ],
            // Teacher planning days
            [
                'nome' => 'Planejamento Pedagógico',
                'data' => "$year-01-31",
                'tipo' => 'escolar',
                'recorrente' => true,
                'observacoes' => 'Dia de planejamento pedagógico'
            ],
            [
                'nome' => 'Conselho de Classe - 1º Bimestre',
                'data' => "$year-04-30",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Conselho de classe do primeiro bimestre'
            ],
            [
                'nome' => 'Conselho de Classe - 2º Bimestre',
                'data' => "$year-06-30",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Conselho de classe do segundo bimestre'
            ],
            [
                'nome' => 'Conselho de Classe - 3º Bimestre',
                'data' => "$year-09-30",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Conselho de classe do terceiro bimestre'
            ],
            [
                'nome' => 'Conselho de Classe - 4º Bimestre',
                'data' => "$year-12-15",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Conselho de classe do quarto bimestre'
            ],
            // Parent-teacher conferences
            [
                'nome' => 'Reunião de Pais - 1º Bimestre',
                'data' => "$year-05-15",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Reunião de pais e responsáveis'
            ],
            [
                'nome' => 'Reunião de Pais - 2º Bimestre',
                'data' => "$year-07-15",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Reunião de pais e responsáveis'
            ],
            [
                'nome' => 'Reunião de Pais - 3º Bimestre',
                'data' => "$year-10-15",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Reunião de pais e responsáveis'
            ],
            [
                'nome' => 'Reunião de Pais - 4º Bimestre',
                'data' => "$year-12-10",
                'tipo' => 'escolar',
                'recorrente' => false,
                'observacoes' => 'Reunião de pais e responsáveis'
            ]
        ];
    }
}
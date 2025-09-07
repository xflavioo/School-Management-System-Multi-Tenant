<?php

namespace App\Services;

use App\Models\CalendarioLetivo;
use App\Models\Feriado;
use App\Models\DiaLetivo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BrazilianCalendarService
{
    /**
     * Create a new academic calendar with Brazilian holidays
     *
     * @param int $year
     * @param Carbon $inicio
     * @param Carbon $fim
     * @param array $options
     * @return CalendarioLetivo
     */
    public function createAcademicCalendar(int $year, Carbon $inicio, Carbon $fim, array $options = [])
    {
        return DB::transaction(function () use ($year, $inicio, $fim, $options) {
            // Create calendar
            $calendario = CalendarioLetivo::create([
                'ano' => $year,
                'inicio' => $inicio,
                'fim' => $fim,
                'dias_letivos_minimos' => $options['dias_letivos_minimos'] ?? 200,
                'active' => $options['active'] ?? true,
                'observacoes' => $options['observacoes'] ?? null
            ]);
            
            // Add Brazilian national holidays
            $this->addBrazilianHolidays($calendario, $year);
            
            // Add custom holidays if provided
            if (isset($options['custom_holidays'])) {
                $this->addCustomHolidays($calendario, $options['custom_holidays']);
            }
            
            return $calendario;
        });
    }

    /**
     * Add Brazilian national holidays to calendar
     *
     * @param CalendarioLetivo $calendario
     * @param int $year
     */
    public function addBrazilianHolidays(CalendarioLetivo $calendario, int $year)
    {
        $holidays = $this->getBrazilianHolidays($year);
        
        foreach ($holidays as $holiday) {
            Feriado::create([
                'calendario_id' => $calendario->id,
                'nome' => $holiday['nome'],
                'data' => $holiday['data'],
                'tipo' => $holiday['tipo'],
                'recorrente' => $holiday['recorrente'],
                'observacoes' => $holiday['observacoes'] ?? null
            ]);
        }
    }

    /**
     * Get Brazilian national holidays for a specific year
     *
     * @param int $year
     * @return array
     */
    public function getBrazilianHolidays(int $year)
    {
        $holidays = [
            // Fixed national holidays
            [
                'nome' => 'Confraternização Universal',
                'data' => "$year-01-01",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Tiradentes',
                'data' => "$year-04-21",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Dia do Trabalhador',
                'data' => "$year-05-01",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Independência do Brasil',
                'data' => "$year-09-07",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Nossa Senhora Aparecida',
                'data' => "$year-10-12",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Finados',
                'data' => "$year-11-02",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Proclamação da República',
                'data' => "$year-11-15",
                'tipo' => 'nacional',
                'recorrente' => true
            ],
            [
                'nome' => 'Natal',
                'data' => "$year-12-25",
                'tipo' => 'nacional',
                'recorrente' => true
            ]
        ];

        // Add mobile holidays (Easter-based)
        $easter = $this->calculateEaster($year);
        
        $holidays[] = [
            'nome' => 'Carnaval (Segunda-feira)',
            'data' => $easter->copy()->subDays(48)->format('Y-m-d'),
            'tipo' => 'nacional',
            'recorrente' => true
        ];
        
        $holidays[] = [
            'nome' => 'Carnaval (Terça-feira)',
            'data' => $easter->copy()->subDays(47)->format('Y-m-d'),
            'tipo' => 'nacional',
            'recorrente' => true
        ];
        
        $holidays[] = [
            'nome' => 'Sexta-feira Santa',
            'data' => $easter->copy()->subDays(2)->format('Y-m-d'),
            'tipo' => 'nacional',
            'recorrente' => true
        ];
        
        $holidays[] = [
            'nome' => 'Corpus Christi',
            'data' => $easter->copy()->addDays(60)->format('Y-m-d'),
            'tipo' => 'nacional',
            'recorrente' => true
        ];

        return $holidays;
    }

    /**
     * Calculate Easter date for a given year
     *
     * @param int $year
     * @return Carbon
     */
    private function calculateEaster(int $year)
    {
        $easter = easter_date($year);
        return Carbon::createFromTimestamp($easter);
    }

    /**
     * Add custom holidays to calendar
     *
     * @param CalendarioLetivo $calendario
     * @param array $holidays
     */
    public function addCustomHolidays(CalendarioLetivo $calendario, array $holidays)
    {
        foreach ($holidays as $holiday) {
            Feriado::create([
                'calendario_id' => $calendario->id,
                'nome' => $holiday['nome'],
                'data' => $holiday['data'],
                'tipo' => $holiday['tipo'] ?? 'escolar',
                'recorrente' => $holiday['recorrente'] ?? false,
                'observacoes' => $holiday['observacoes'] ?? null
            ]);
        }
    }

    /**
     * Generate automatic academic calendar suggestion
     *
     * @param int $year
     * @return array
     */
    public function generateCalendarSuggestion(int $year)
    {
        // Brazilian academic year typically runs February to December
        $inicio = Carbon::create($year, 2, 1); // February 1st
        $fim = Carbon::create($year, 12, 20); // December 20th
        
        // Adjust start date to avoid weekends
        while ($inicio->isWeekend()) {
            $inicio->addDay();
        }
        
        // Adjust end date to avoid weekends
        while ($fim->isWeekend()) {
            $fim->subDay();
        }
        
        return [
            'ano' => $year,
            'inicio' => $inicio,
            'fim' => $fim,
            'total_days' => $inicio->diffInDays($fim) + 1,
            'weekdays' => $this->countWeekdays($inicio, $fim),
            'estimated_school_days' => $this->estimateSchoolDays($year, $inicio, $fim)
        ];
    }

    /**
     * Count weekdays between two dates
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return int
     */
    private function countWeekdays(Carbon $start, Carbon $end)
    {
        $weekdays = 0;
        $current = $start->copy();
        
        while ($current->lte($end)) {
            if (!$current->isWeekend()) {
                $weekdays++;
            }
            $current->addDay();
        }
        
        return $weekdays;
    }

    /**
     * Estimate school days (weekdays minus holidays)
     *
     * @param int $year
     * @param Carbon $start
     * @param Carbon $end
     * @return int
     */
    private function estimateSchoolDays(int $year, Carbon $start, Carbon $end)
    {
        $weekdays = $this->countWeekdays($start, $end);
        $holidays = $this->getBrazilianHolidays($year);
        
        $holidayDays = 0;
        foreach ($holidays as $holiday) {
            $holidayDate = Carbon::parse($holiday['data']);
            if ($holidayDate->between($start, $end) && !$holidayDate->isWeekend()) {
                $holidayDays++;
            }
        }
        
        return $weekdays - $holidayDays;
    }

    /**
     * Validate calendar meets minimum requirements
     *
     * @param CalendarioLetivo $calendario
     * @return array
     */
    public function validateCalendar(CalendarioLetivo $calendario)
    {
        $schoolDays = $calendario->calculateDiasLetivos();
        $minimumRequired = $calendario->dias_letivos_minimos;
        $isValid = $schoolDays >= $minimumRequired;
        
        return [
            'valid' => $isValid,
            'school_days' => $schoolDays,
            'minimum_required' => $minimumRequired,
            'difference' => $schoolDays - $minimumRequired,
            'message' => $isValid 
                ? 'Calendário atende aos requisitos mínimos.'
                : "Calendário não atende aos requisitos. Faltam " . ($minimumRequired - $schoolDays) . " dias letivos."
        ];
    }

    /**
     * Copy holidays from previous year for recurring ones
     *
     * @param int $fromYear
     * @param int $toYear
     * @return int Number of holidays copied
     */
    public function copyRecurringHolidays(int $fromYear, int $toYear)
    {
        $fromCalendar = CalendarioLetivo::where('ano', $fromYear)->first();
        $toCalendar = CalendarioLetivo::where('ano', $toYear)->first();
        
        if (!$fromCalendar || !$toCalendar) {
            return 0;
        }
        
        $recurringHolidays = $fromCalendar->feriados()->where('recorrente', true)->get();
        $copied = 0;
        
        foreach ($recurringHolidays as $holiday) {
            $newHolidayData = $holiday->generateNextYear($toYear);
            if ($newHolidayData) {
                $newHolidayData['calendario_id'] = $toCalendar->id;
                Feriado::create($newHolidayData);
                $copied++;
            }
        }
        
        return $copied;
    }
}
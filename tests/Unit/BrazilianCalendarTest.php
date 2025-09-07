<?php

namespace Tests\Unit;

use App\Models\CalendarioLetivo;
use App\Models\Feriado;
use App\Services\BrazilianCalendarService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class BrazilianCalendarTest extends TestCase
{
    /** @test */
    public function calendario_letivo_model_has_correct_attributes()
    {
        $calendario = new CalendarioLetivo([
            'ano' => 2024,
            'inicio' => '2024-02-01',
            'fim' => '2024-12-20',
            'dias_letivos_minimos' => 200,
            'active' => true,
            'observacoes' => 'Calendário teste'
        ]);

        $this->assertEquals(2024, $calendario->ano);
        $this->assertEquals('2024-02-01', $calendario->inicio);
        $this->assertEquals('2024-12-20', $calendario->fim);
        $this->assertEquals(200, $calendario->dias_letivos_minimos);
        $this->assertTrue($calendario->active);
        $this->assertEquals('Calendário teste', $calendario->observacoes);
    }

    /** @test */
    public function feriado_model_has_correct_attributes()
    {
        $feriado = new Feriado([
            'calendario_id' => 1,
            'nome' => 'Natal',
            'data' => '2024-12-25',
            'tipo' => 'nacional',
            'recorrente' => true,
            'observacoes' => 'Feriado nacional'
        ]);

        $this->assertEquals(1, $feriado->calendario_id);
        $this->assertEquals('Natal', $feriado->nome);
        $this->assertEquals('2024-12-25', $feriado->data);
        $this->assertEquals('nacional', $feriado->tipo);
        $this->assertTrue($feriado->recorrente);
        $this->assertEquals('Feriado nacional', $feriado->observacoes);
    }

    /** @test */
    public function feriado_formats_date_correctly()
    {
        $feriado = new Feriado([
            'data' => '2024-12-25'
        ]);

        $this->assertEquals('25/12/2024', $feriado->getDataFormatadaAttribute());
    }

    /** @test */
    public function feriado_detects_weekend_correctly()
    {
        // Christmas 2024 falls on a Wednesday
        $feriado = new Feriado([
            'data' => '2024-12-25'
        ]);

        $this->assertFalse($feriado->isFinalSemana());

        // New Year 2025 falls on a Wednesday
        $feriado2 = new Feriado([
            'data' => '2025-01-01'
        ]);

        $this->assertFalse($feriado2->isFinalSemana());
    }

    /** @test */
    public function feriado_gets_type_description()
    {
        $nacional = new Feriado(['tipo' => 'nacional']);
        $estadual = new Feriado(['tipo' => 'estadual']);
        $municipal = new Feriado(['tipo' => 'municipal']);
        $escolar = new Feriado(['tipo' => 'escolar']);

        $this->assertEquals('Feriado Nacional', $nacional->getTipoDescricaoAttribute());
        $this->assertEquals('Feriado Estadual', $estadual->getTipoDescricaoAttribute());
        $this->assertEquals('Feriado Municipal', $municipal->getTipoDescricaoAttribute());
        $this->assertEquals('Feriado Escolar', $escolar->getTipoDescricaoAttribute());
    }

    /** @test */
    public function calendar_service_generates_brazilian_holidays()
    {
        $service = new BrazilianCalendarService();
        $holidays = $service->getBrazilianHolidays(2024);

        $this->assertIsArray($holidays);
        $this->assertGreaterThan(10, count($holidays)); // Should have at least 11+ holidays

        // Check for some fixed holidays
        $holidayNames = array_column($holidays, 'nome');
        $this->assertContains('Natal', $holidayNames);
        $this->assertContains('Independência do Brasil', $holidayNames);
        $this->assertContains('Tiradentes', $holidayNames);
        $this->assertContains('Carnaval (Segunda-feira)', $holidayNames);
        $this->assertContains('Sexta-feira Santa', $holidayNames);
    }

    /** @test */
    public function calendar_service_generates_correct_holiday_dates()
    {
        $service = new BrazilianCalendarService();
        $holidays = $service->getBrazilianHolidays(2024);

        // Find specific holidays and check their dates
        foreach ($holidays as $holiday) {
            switch ($holiday['nome']) {
                case 'Natal':
                    $this->assertEquals('2024-12-25', $holiday['data']);
                    $this->assertEquals('nacional', $holiday['tipo']);
                    $this->assertTrue($holiday['recorrente']);
                    break;
                case 'Independência do Brasil':
                    $this->assertEquals('2024-09-07', $holiday['data']);
                    break;
                case 'Tiradentes':
                    $this->assertEquals('2024-04-21', $holiday['data']);
                    break;
            }
        }
    }

    /** @test */
    public function calendar_service_calculates_weekdays_correctly()
    {
        $service = new BrazilianCalendarService();
        
        // Use reflection to test private method
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('countWeekdays');
        $method->setAccessible(true);
        
        // Test a week with 5 weekdays
        $start = Carbon::create(2024, 1, 1); // Monday
        $end = Carbon::create(2024, 1, 7);   // Sunday
        
        $weekdays = $method->invoke($service, $start, $end);
        $this->assertEquals(5, $weekdays); // Mon-Fri
    }

    /** @test */
    public function calendar_suggestion_has_correct_structure()
    {
        $service = new BrazilianCalendarService();
        $suggestion = $service->generateCalendarSuggestion(2024);

        $this->assertArrayHasKey('ano', $suggestion);
        $this->assertArrayHasKey('inicio', $suggestion);
        $this->assertArrayHasKey('fim', $suggestion);
        $this->assertArrayHasKey('total_days', $suggestion);
        $this->assertArrayHasKey('weekdays', $suggestion);
        $this->assertArrayHasKey('estimated_school_days', $suggestion);

        $this->assertEquals(2024, $suggestion['ano']);
        $this->assertInstanceOf(Carbon::class, $suggestion['inicio']);
        $this->assertInstanceOf(Carbon::class, $suggestion['fim']);
        $this->assertIsInt($suggestion['total_days']);
        $this->assertIsInt($suggestion['weekdays']);
        $this->assertIsInt($suggestion['estimated_school_days']);
    }

    /** @test */
    public function recurring_holiday_generates_next_year_correctly()
    {
        $feriado = new Feriado([
            'nome' => 'Natal',
            'data' => '2024-12-25',
            'tipo' => 'nacional',
            'recorrente' => true,
            'observacoes' => 'Feriado nacional'
        ]);

        $nextYear = $feriado->generateNextYear(2025);

        $this->assertIsArray($nextYear);
        $this->assertEquals('Natal', $nextYear['nome']);
        $this->assertEquals('2025-12-25', $nextYear['data']);
        $this->assertEquals('nacional', $nextYear['tipo']);
        $this->assertTrue($nextYear['recorrente']);
        $this->assertEquals('Feriado nacional', $nextYear['observacoes']);
    }

    /** @test */
    public function non_recurring_holiday_does_not_generate_next_year()
    {
        $feriado = new Feriado([
            'nome' => 'Evento Especial',
            'data' => '2024-06-15',
            'tipo' => 'escolar',
            'recorrente' => false
        ]);

        $nextYear = $feriado->generateNextYear(2025);

        $this->assertNull($nextYear);
    }
}
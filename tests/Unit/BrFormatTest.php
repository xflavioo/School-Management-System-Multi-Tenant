<?php

namespace Tests\Unit;

use App\Support\BrFormat;
use PHPUnit\Framework\TestCase;

class BrFormatTest extends TestCase
{
    /** @test */
    public function it_formats_dates_correctly()
    {
        $date = '2023-12-25 12:00:00';
        $carbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date, 'America/Sao_Paulo');
        $formatted = BrFormat::date($carbon);
        
        $this->assertEquals('25/12/2023', $formatted);
    }

    /** @test */
    public function it_formats_datetime_correctly()
    {
        $datetime = '2023-12-25 14:30:00';
        $carbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $datetime, 'America/Sao_Paulo');
        $formatted = BrFormat::datetime($carbon);
        
        $this->assertEquals('25/12/2023 14:30', $formatted);
    }

    /** @test */
    public function it_formats_money_correctly()
    {
        $value = 1234.56;
        $formatted = BrFormat::money($value);
        
        $this->assertEquals('R$ 1.234,56', $formatted);
    }

    /** @test */
    public function it_formats_numbers_correctly()
    {
        $value = 1234.56;
        $formatted = BrFormat::number($value);
        
        $this->assertEquals('1.234,56', $formatted);
    }

    /** @test */
    public function it_formats_numbers_with_custom_decimals()
    {
        $value = 1234.56789;
        $formatted = BrFormat::number($value, 3);
        
        $this->assertEquals('1.234,568', $formatted);
    }

    /** @test */
    public function it_handles_null_values_gracefully()
    {
        $this->assertEquals('', BrFormat::date(null));
        $this->assertEquals('', BrFormat::datetime(null));
        $this->assertEquals('', BrFormat::money(null));
        $this->assertEquals('', BrFormat::number(null));
    }

    /** @test */
    public function it_handles_empty_values_gracefully()
    {
        $this->assertEquals('', BrFormat::date(''));
        $this->assertEquals('', BrFormat::datetime(''));
        $this->assertEquals('', BrFormat::number(''));
    }
}
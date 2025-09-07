<?php

namespace Tests\Unit;

use App\Helpers\BrazilianFormat;
use PHPUnit\Framework\TestCase;

class BrazilianFormatTest extends TestCase
{
    /** @test */
    public function it_formats_cpf_correctly()
    {
        $cpf = '12345678901';
        $formatted = BrazilianFormat::cpf($cpf);
        
        $this->assertEquals('123.456.789-01', $formatted);
    }

    /** @test */
    public function it_formats_cnpj_correctly()
    {
        $cnpj = '12345678000195';
        $formatted = BrazilianFormat::cnpj($cnpj);
        
        $this->assertEquals('12.345.678/0001-95', $formatted);
    }

    /** @test */
    public function it_formats_cep_correctly()
    {
        $cep = '12345678';
        $formatted = BrazilianFormat::cep($cep);
        
        $this->assertEquals('12345-678', $formatted);
    }

    /** @test */
    public function it_formats_mobile_phone_correctly()
    {
        $phone = '11987654321';
        $formatted = BrazilianFormat::phone($phone);
        
        $this->assertEquals('(11) 98765-4321', $formatted);
    }

    /** @test */
    public function it_formats_landline_phone_correctly()
    {
        $phone = '1112345678';
        $formatted = BrazilianFormat::phone($phone);
        
        $this->assertEquals('(11) 1234-5678', $formatted);
    }

    /** @test */
    public function it_formats_money_correctly()
    {
        $value = 1234.56;
        $formatted = BrazilianFormat::money($value);
        
        $this->assertEquals('R$ 1.234,56', $formatted);
    }

    /** @test */
    public function it_validates_valid_cpf()
    {
        // Using a valid CPF for testing: 11144477735
        $validCpf = '11144477735';
        
        $this->assertTrue(BrazilianFormat::validateCpf($validCpf));
    }

    /** @test */
    public function it_rejects_invalid_cpf()
    {
        $invalidCpf = '12345678901';
        
        $this->assertFalse(BrazilianFormat::validateCpf($invalidCpf));
    }

    /** @test */
    public function it_rejects_cpf_with_same_digits()
    {
        $invalidCpf = '11111111111';
        
        $this->assertFalse(BrazilianFormat::validateCpf($invalidCpf));
    }

    /** @test */
    public function it_validates_cep_format()
    {
        $validCep = '12345678';
        $invalidCep = '1234567';
        
        $this->assertTrue(BrazilianFormat::validateCep($validCep));
        $this->assertFalse(BrazilianFormat::validateCep($invalidCep));
    }

    /** @test */
    public function it_formats_dates_to_brazilian_format()
    {
        // Use a specific datetime to avoid timezone issues in unit tests
        $date = '2023-12-25 12:00:00';
        $carbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date, 'America/Sao_Paulo');
        $formatted = BrazilianFormat::date($carbon);
        
        $this->assertEquals('25/12/2023', $formatted);
    }

    /** @test */
    public function it_formats_numbers_correctly()
    {
        $value = 1234.56;
        $formatted = BrazilianFormat::number($value);
        
        $this->assertEquals('1.234,56', $formatted);
    }

    /** @test */
    public function it_formats_numbers_with_custom_decimals()
    {
        $value = 1234.56789;
        $formatted = BrazilianFormat::number($value, 3);
        
        $this->assertEquals('1.234,568', $formatted);
    }

    /** @test */
    public function it_handles_null_values_gracefully()
    {
        $this->assertEquals('', BrazilianFormat::date(null));
        $this->assertEquals('', BrazilianFormat::datetime(null));
        $this->assertEquals('', BrazilianFormat::money(null));
        $this->assertEquals('', BrazilianFormat::number(null));
    }
}
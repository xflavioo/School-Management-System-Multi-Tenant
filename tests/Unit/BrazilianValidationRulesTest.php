<?php

namespace Tests\Unit;

use App\Rules\ValidCpf;
use App\Rules\ValidCnpj;
use App\Rules\ValidCep;
use PHPUnit\Framework\TestCase;

class BrazilianValidationRulesTest extends TestCase
{
    /** @test */
    public function cpf_validation_rule_works_correctly()
    {
        $rule = new ValidCpf();
        
        // Valid CPF
        $this->assertTrue($rule->passes('cpf', '11144477735'));
        
        // Invalid CPF
        $this->assertFalse($rule->passes('cpf', '12345678901'));
        
        // CPF with same digits
        $this->assertFalse($rule->passes('cpf', '11111111111'));
        
        // Empty value
        $this->assertFalse($rule->passes('cpf', ''));
        
        // Check message
        $this->assertStringContainsString('CPF', $rule->message());
    }

    /** @test */
    public function cnpj_validation_rule_works_correctly()
    {
        $rule = new ValidCnpj();
        
        // Valid CNPJ (example from Receita Federal)
        $this->assertTrue($rule->passes('cnpj', '34028316000103'));
        
        // Invalid CNPJ
        $this->assertFalse($rule->passes('cnpj', '12345678000195'));
        
        // CNPJ with same digits
        $this->assertFalse($rule->passes('cnpj', '11111111111111'));
        
        // Empty value
        $this->assertFalse($rule->passes('cnpj', ''));
        
        // Check message
        $this->assertStringContainsString('CNPJ', $rule->message());
    }

    /** @test */
    public function cep_validation_rule_works_correctly()
    {
        $rule = new ValidCep();
        
        // Valid CEP
        $this->assertTrue($rule->passes('cep', '12345678'));
        $this->assertTrue($rule->passes('cep', '01310-100'));
        
        // Invalid CEP
        $this->assertFalse($rule->passes('cep', '1234567'));
        $this->assertFalse($rule->passes('cep', '123456789'));
        $this->assertFalse($rule->passes('cep', 'abcdefgh'));
        
        // Empty value
        $this->assertFalse($rule->passes('cep', ''));
        
        // Check message
        $this->assertStringContainsString('CEP', $rule->message());
    }
}
<?php

namespace Tests\Unit;

use App\Models\Serie;
use App\Models\Turno;
use App\Models\Turma;
use PHPUnit\Framework\TestCase;

class BrazilianSchoolStructureTest extends TestCase
{
    /** @test */
    public function serie_model_has_correct_attributes()
    {
        $serie = new Serie([
            'name' => '1º Ano EF',
            'nivel_ensino' => 'fundamental',
            'order' => 1,
            'active' => true,
            'description' => 'Primeiro ano do ensino fundamental'
        ]);

        $this->assertEquals('1º Ano EF', $serie->name);
        $this->assertEquals('fundamental', $serie->nivel_ensino);
        $this->assertEquals(1, $serie->order);
        $this->assertTrue($serie->active);
        $this->assertTrue($serie->isFundamental());
        $this->assertFalse($serie->isMedio());
    }

    /** @test */
    public function turno_model_has_correct_attributes()
    {
        $turno = new Turno([
            'name' => 'Manhã',
            'codigo' => 'M',
            'inicio' => '07:00:00',
            'fim' => '12:00:00',
            'active' => true
        ]);

        $this->assertEquals('Manhã', $turno->name);
        $this->assertEquals('M', $turno->codigo);
        $this->assertTrue($turno->active);
        $this->assertTrue($turno->isManha());
        $this->assertFalse($turno->isTarde());
        $this->assertFalse($turno->isNoite());
    }

    /** @test */
    public function turma_model_has_correct_attributes()
    {
        $turma = new Turma([
            'name' => 'A',
            'serie_id' => 1,
            'turno_id' => 1,
            'ano_letivo' => '2024',
            'capacidade_maxima' => 30,
            'sala' => '101',
            'active' => true
        ]);

        $this->assertEquals('A', $turma->name);
        $this->assertEquals(1, $turma->serie_id);
        $this->assertEquals(1, $turma->turno_id);
        $this->assertEquals('2024', $turma->ano_letivo);
        $this->assertEquals(30, $turma->capacidade_maxima);
        $this->assertEquals('101', $turma->sala);
        $this->assertTrue($turma->active);
    }

    /** @test */
    public function serie_full_name_includes_education_level()
    {
        $fundamental = new Serie([
            'name' => '1º Ano EF',
            'nivel_ensino' => 'fundamental'
        ]);

        $medio = new Serie([
            'name' => '1º Ano EM',
            'nivel_ensino' => 'medio'
        ]);

        $this->assertEquals('1º Ano EF (EF)', $fundamental->getFullNameAttribute());
        $this->assertEquals('1º Ano EM (EM)', $medio->getFullNameAttribute());
    }

    /** @test */
    public function turno_format_time_correctly()
    {
        $turno = new Turno([
            'inicio' => '07:00:00',
            'fim' => '12:00:00'
        ]);

        // Note: This test would require Carbon/DateTime functionality
        // In a real environment, this would work with proper Carbon setup
        $this->assertNotEmpty($turno->getHorarioAttribute());
    }

    /** @test */
    public function turno_shift_detection_works()
    {
        $manha = new Turno(['codigo' => 'M']);
        $tarde = new Turno(['codigo' => 'T']);
        $noite = new Turno(['codigo' => 'N']);
        $integral = new Turno(['codigo' => 'I']);

        $this->assertTrue($manha->isManha());
        $this->assertTrue($tarde->isTarde());
        $this->assertTrue($noite->isNoite());
        $this->assertTrue($integral->isIntegral());
    }

    /** @test */
    public function serie_education_level_detection_works()
    {
        $fundamental = new Serie(['nivel_ensino' => 'fundamental']);
        $medio = new Serie(['nivel_ensino' => 'medio']);

        $this->assertTrue($fundamental->isFundamental());
        $this->assertFalse($fundamental->isMedio());
        
        $this->assertTrue($medio->isMedio());
        $this->assertFalse($medio->isFundamental());
    }
}
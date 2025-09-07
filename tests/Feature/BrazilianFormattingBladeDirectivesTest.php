<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Blade;

class BrazilianFormattingBladeDirectivesTest extends TestCase
{
    /** @test */
    public function blade_directives_are_registered_correctly()
    {
        // Test @dateBR directive
        $compiled = Blade::compileString('@dateBR("2023-12-25")');
        $this->assertStringContainsString('App\Support\BrFormat::date', $compiled);

        // Test @datetimeBR directive
        $compiled = Blade::compileString('@datetimeBR("2023-12-25 14:30:00")');
        $this->assertStringContainsString('App\Support\BrFormat::datetime', $compiled);

        // Test @moneyBR directive
        $compiled = Blade::compileString('@moneyBR(1234.56)');
        $this->assertStringContainsString('App\Support\BrFormat::money', $compiled);

        // Test @numberBR directive
        $compiled = Blade::compileString('@numberBR(1234.56)');
        $this->assertStringContainsString('App\Support\BrFormat::number', $compiled);
    }

    /** @test */
    public function blade_directives_render_correctly()
    {
        // Create test view content
        $viewContent = '
            Date: @dateBR("2023-12-25")
            DateTime: @datetimeBR("2023-12-25 14:30:00")
            Money: @moneyBR(1234.56)
            Number: @numberBR(1234.56)
        ';

        // Compile and render the view
        $compiled = Blade::compileString($viewContent);
        
        // Check that the directives were compiled
        $this->assertStringContainsString('BrFormat::date', $compiled);
        $this->assertStringContainsString('BrFormat::datetime', $compiled);
        $this->assertStringContainsString('BrFormat::money', $compiled);
        $this->assertStringContainsString('BrFormat::number', $compiled);
    }
}
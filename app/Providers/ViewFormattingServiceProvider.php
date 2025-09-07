<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Support\BrFormat;

class ViewFormattingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Brazilian formatting Blade directives
        Blade::directive('dateBR', fn($expression) => "<?php echo \\App\\Support\\BrFormat::date($expression); ?>");
        Blade::directive('datetimeBR', fn($expression) => "<?php echo \\App\\Support\\BrFormat::datetime($expression); ?>");
        Blade::directive('moneyBR', fn($expression) => "<?php echo \\App\\Support\\BrFormat::money($expression); ?>");
        Blade::directive('numberBR', fn($expression) => "<?php echo \\App\\Support\\BrFormat::number($expression); ?>");
    }
}
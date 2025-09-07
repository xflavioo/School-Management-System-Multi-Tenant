<?php

namespace App\Providers;

use App\Helpers\BrazilianFormat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set Carbon locale to Brazilian Portuguese
        Carbon::setLocale('pt_BR');
        setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'portuguese');

        // Register Brazilian formatting Blade directives
        Blade::directive('dateBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::date($expression); ?>";
        });

        Blade::directive('datetimeBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::datetime($expression); ?>";
        });

        Blade::directive('moneyBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::money($expression); ?>";
        });

        Blade::directive('cpfBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::cpf($expression); ?>";
        });

        Blade::directive('cnpjBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::cnpj($expression); ?>";
        });

        Blade::directive('cepBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::cep($expression); ?>";
        });

        Blade::directive('phoneBR', function ($expression) {
            return "<?php echo App\Helpers\BrazilianFormat::phone($expression); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}

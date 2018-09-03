<?php

namespace Acostadu\Pagos_pro;

use Illuminate\Support\ServiceProvider;

class PagosProServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->app->make('Acostadu\PagosPro\Controllers\MainController');
    }
}

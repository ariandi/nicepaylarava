<?php
namespace Ari\Cc;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // echo 123;die;
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        // $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'cc');
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/nicepay/cc'),
        // ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Ari\Cc\NicepayVaController');
    }
}

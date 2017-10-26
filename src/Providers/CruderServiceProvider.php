<?php

namespace Sarav\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CruderServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register('Sarav\Providers\RouteServiceProvider');

        View::addLocation(realpath(__DIR__.'/../resources/views'));
    }

    /**
     * Publishes admin configuration
     * 
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/admin.php');

        $this->publishes([$source => config_path('admin.php')]);
    }
}
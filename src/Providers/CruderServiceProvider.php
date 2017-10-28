<?php

namespace Sarav\Providers;

use Illuminate\Support\Composer;
use Illuminate\Support\Facades\View;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Sarav\Command\InitializeCruder;

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
        $this->setupAssets();
        $this->registerConsoleCommand();
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

    public function setupAssets()
    {
        $css = realpath(__DIR__.'/../assets/css/admin/admin.css');

        $this->publishes([$css => public_path('css/admin/admin.css')]);

        $js = realpath(__DIR__.'/../assets/js/admin/mc.vue.js');

        $this->publishes([$js => public_path('js/admin/mc.vue.js')]);
    }


    private function registerConsoleCommand()
    {
        $this->app->singleton('command.initialize.cruder', function () {
            return new InitializeCruder();
        });
        
        $this->commands(['command.initialize.cruder']);
    }
}

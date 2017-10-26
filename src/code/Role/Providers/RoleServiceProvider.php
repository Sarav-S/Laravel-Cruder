<?php

namespace Code\Role\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register's application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Code\Role\Providers\RouteServiceProvider');

        View::addLocation(realpath(__DIR__.'/../resources/views'));
    }
}

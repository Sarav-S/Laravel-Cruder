<?php

namespace Code\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Code\Auth\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->registerMenus();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Registers the admin menu
     */
    protected function registerMenus()
    {
        // $menu = app('menu');
        // $menu->make('AdminNavBar', function($menu){
            
        // });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
        ], function ($router) {
            require __DIR__.'/../routes/web.php';
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
        ], function ($router) {
            require __DIR__.'/../routes/admin.php';
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes all receive nothing. They are broke as hell.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            //'middleware' => '',
            'namespace'  => $this->namespace,
            'prefix'    =>  'api'
        ], function ($router) {
            require __DIR__.'/../routes/api.php';
        });
    }
}

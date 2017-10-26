<?php

namespace Code\Role\Providers;

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
    protected $namespace = 'Code\Role\Http\Controllers';

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
        $this->mapAdminRoutes();
        $this->registerMiddlewares();
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
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin.auth', 'permission'],
            'namespace'  => $this->namespace,
            'prefix'     => config('admin.url'),
            'as'         => 'admin.'
        ], function ($router) {
            require __DIR__.'/../routes/admin.php';
        });
    }

    /**
     * Registers the necessary middlewares
     */
    protected function registerMiddlewares()
    {
        Route::aliasMiddleware('permission',  \Code\Role\Http\Middleware\PermissionMiddleware::class);
    }
}

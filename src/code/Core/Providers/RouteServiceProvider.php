<?php

namespace Code\Core\Providers;

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
    protected $namespace = 'Code\Core\Http\Controllers';

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
        $this->registerMiddlewares();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
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
     * Registers the necessary middlewares
     */
    protected function registerMiddlewares()
    {
        Route::aliasMiddleware('auth',  \Code\Core\Http\Middleware\Authenticate::class);
        Route::aliasMiddleware('guest',  \Code\Core\Http\Middleware\RedirectIfAuthenticated::class);

        Route::aliasMiddleware('admin.auth',  \Code\Core\Http\Middleware\AdminAuthenticate::class);
        Route::aliasMiddleware('admin.guest',  \Code\Core\Http\Middleware\AdminRedirectIfAuthenticated::class);
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
        ], function ($router) {
            require __DIR__.'/../routes/admin.php';
        });
    }
}

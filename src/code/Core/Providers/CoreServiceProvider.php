<?php

namespace Code\Core\Providers;

use Code\Core\Exceptions\Handler;
use Code\Core\Routing\Router;
use Code\Core\Routing\Redirector;
use Code\Core\Routing\UrlGenerator;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Overriding Laravel's Core Exception Handler
         * by our own Exception Handler
         */
        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );
        $this->registerBreadcrumbs();
    }

    /**
     * Register's application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Setting default config to Asia/Kolkata
         * TODO : This should be dynamic from backend
         */
        date_default_timezone_set('Asia/Kolkata');

        $this->app->register('Code\Core\Providers\RouteServiceProvider');

        $this->app->register('Code\Auth\Providers\AuthServiceProvider');
        $this->app->register('Code\Admin\Providers\AdminServiceProvider');
        $this->app->register('Code\User\Providers\UserServiceProvider');
        $this->app->register('Code\Role\Providers\RoleServiceProvider');
        $this->app->register('Code\Setting\Providers\SettingServiceProvider');

        $this->registerThirdPartyPackages();
        $this->registerThirdPartyAliases();

        View::addLocation(realpath(__DIR__.'/../resources/views'));
    }

    protected function registerThirdPartyPackages()
    {
        $this->app->register('DaveJamesMiller\Breadcrumbs\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Laravel\Socialite\SocialiteServiceProvider');
    }

    protected function registerThirdPartyAliases()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Breadcrumbs', 'DaveJamesMiller\Breadcrumbs\Facade');
            $loader->alias('Form', 'Collective\Html\FormFacade');
            $loader->alias('Html', 'Collective\Html\HtmlFacade');
            $loader->alias('Socialite', 'Laravel\Socialite\Facades\Socialite');
        });
    }

     /**
     * Registers the admin breadcrumbs
     */
    public function registerBreadcrumbs()
    {
        if (file_exists($file = realpath(__DIR__.'/../breadcrumbs/links.php'))) {
            require $file;
        }
    }
}

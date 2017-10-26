<?php

namespace Code\Auth\Providers;

use Code\User\Model\User;
use Code\Admin\Model\Admin;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerSocialiteConfig();
    }

    /**
     * Register's application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Code\Auth\Providers\RouteServiceProvider');

        $this->registerAuthConfig();

        View::addLocation(realpath(__DIR__.'/../resources/views'));
    }

    public function registerAuthConfig()
    {
        $config = $this->app['config']['auth'];

        $config['guards']['admin'] = [
            'driver'   => 'session',
            'provider' => 'admins',
        ];

        $config['providers']['users'] = [
            'driver' => 'eloquent',
            'model'  => User::class,
        ];

        $config['providers']['admins'] = [
            'driver' => 'eloquent',
            'model'  => Admin::class,
        ];

        $config['passwords']['admins'] = [
            'provider' => 'admins',
            'table'    => 'password_resets',
            'expire'   => 60,
        ];

        $this->app['config']['auth'] = $config;
    }

    public function registerSocialiteConfig()
    {
        $config = $this->app['config']['services'];

        $providers = ['facebook', 'google', 'twitter'];

        foreach ($providers as $provider) {
            $config[$provider] = [
                'client_id'     => setting($provider.'_client_id'),
                'client_secret' => setting($provider.'_client_secret'),
                'redirect'      => url('social/auth', $provider)
            ];
        }

        $this->app['config']['services'] = $config;
    }
}

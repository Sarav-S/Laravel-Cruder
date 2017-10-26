<?php

namespace Sarav\Providers;

use Illuminate\Support\Composer;
use Illuminate\Support\Facades\View;
use Illuminate\Filesystem\Filesystem;
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
        $this->setupAssets();
        $this->removeBoilerPlateMigrationsFiles();
        $this->initializeCoreModules();
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

    public function removeBoilerPlateMigrationsFiles()
    {
        \File::cleanDirectory(database_path('migrations'));
    }

    public function initializeCoreModules()
    {
        $sourceFolder      = __DIR__.'/../code';
        $destinationFolder = base_path().'/code';

        \File::copyDirectory($sourceFolder, $destinationFolder);

        $this->setupComposerNamespace();
    }

    public function setupComposerNamespace()
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $autoload = $composer['autoload'];

        if (!array_key_exists("Code\\", $autoload['psr-4'])) {
            $autoload['psr-4']["Code\\"] = "code/";
        }

        if (!isset($autoload['files'])) {
            $autoload['files'] = [];
        }

        if (!in_array("code/Core/Helper/helper.php", $autoload['files'])) {
            $autoload['files'][] = "code/Core/Helper/helper.php";
        }

        $composer['autoload'] = $autoload;

        $postAutoloadDump = $composer['scripts'];

        $composer['scripts'] = [];

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );

        $composerInstance = new Composer(new Filesystem);
        $composerInstance->dumpAutoloads();

        $composer['scripts'] = $postAutoloadDump;

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}

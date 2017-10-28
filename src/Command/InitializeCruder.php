<?php

namespace Sarav\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

class InitializeCruder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initializer:cruder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes the cruder core files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->removeBoilerPlateMigrationsFiles();
        $this->initializeCoreModules();
    }

    public function removeBoilerPlateMigrationsFiles()
    {
        \File::cleanDirectory(database_path('migrations'));

        $this->comment('Removed default migration files.');
    }

    public function initializeCoreModules()
    {
        $sourceFolder      = __DIR__.'/../code';
        $destinationFolder = base_path().'/code';

        \File::copyDirectory($sourceFolder, $destinationFolder);

        $this->comment('Copied cruder core files!');

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

        $this->comment('Core files deployed!');
        $this->comment('<info>Happy Coding! :)</info> ');
    }
}

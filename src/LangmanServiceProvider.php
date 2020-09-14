<?php

namespace Sararabie\Langman;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class LangmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/langman.php' => config_path('langman.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/langman.php', 'langman');

        $this->app->bind(Manager::class, function () {
            return new Manager(
                new Filesystem,
                $this->app['config']['langman.path'],
                array_merge($this->app['config']['view.paths'], [$this->app['path']])
            );
        });

        $this->commands([
            \Sararabie\Langman\Commands\MissingCommand::class,
            \Sararabie\Langman\Commands\RemoveCommand::class,
            \Sararabie\Langman\Commands\TransCommand::class,
            \Sararabie\Langman\Commands\ShowCommand::class,
            \Sararabie\Langman\Commands\FindCommand::class,
            \Sararabie\Langman\Commands\SyncCommand::class,
            \Sararabie\Langman\Commands\RenameCommand::class,
        ]);
    }
}

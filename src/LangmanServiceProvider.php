<?php

namespace MahmoudNaguib\Langman;

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
            \MahmoudNaguib\Langman\Commands\MissingCommand::class,
            \MahmoudNaguib\Langman\Commands\RemoveCommand::class,
            \MahmoudNaguib\Langman\Commands\TransCommand::class,
            \MahmoudNaguib\Langman\Commands\ShowCommand::class,
            \MahmoudNaguib\Langman\Commands\FindCommand::class,
            \MahmoudNaguib\Langman\Commands\SyncCommand::class,
            \MahmoudNaguib\Langman\Commands\RenameCommand::class,
        ]);
    }
}

<?php

namespace Almazik\LaravelUploader;

use Illuminate\Support\ServiceProvider;

class FileUploaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'laravelUploader');

        $this->publishes(
            [
                __DIR__ . '/../../views' => base_path('resources/views/vendor/laravelUploader'),
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';

        $this->app->make('Almazik\LaravelUploader\LaravelUploaderController');
    }
}

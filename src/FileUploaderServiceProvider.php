<?php

namespace Almazik\LaravelUploader;

use Almazik\LaravelUploader\Uploader;
use Illuminate\Support\ServiceProvider;
use Almazik\LaravelUploader\LaravelUploader;

class FileUploaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadViewsFrom(__DIR__ . '/../../views', 'laravelUploader');

        // $this->publishes(
        //     [
        //         __DIR__ . '/../../views' => base_path('resources/views/vendor/laravelUploader'),
        //     ]
        // );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Uploader::class, LaravelUploader::class);

        $this->app->bindShared('uploader', function () {
            return $this->app->make(Uploader::class);
        });
    }
}

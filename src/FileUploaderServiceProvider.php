<?php

namespace Almazik\LaravelUploader;

use Illuminate\Support\ServiceProvider;
use Almazik\LaravelUploader\LaravelUploader;
use Almazik\LaravelUploader\Contracts\Uploader;

class FileUploaderServiceProvider extends ServiceProvider
{
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

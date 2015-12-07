<?php

namespace Almazik\LaravelUploader\Facades;

use Illuminate\Support\Facades\Facade;

class Uploader extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploader';
    }
}
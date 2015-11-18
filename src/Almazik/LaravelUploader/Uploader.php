<?php

namespace Almazik\LaravelUploader;

interface Uploader
{
    public function go($file, $path = '');
}
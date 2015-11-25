<?php

namespace Almazik\LaravelUploader\Contracts;

interface Uploader
{
    public function file($file);

    public function push($path = '');
}
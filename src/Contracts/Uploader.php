<?php

namespace Almazik\LaravelUploader\Contracts;

interface Uploader
{
    /**
     * @param $file
     * @return mixed
     */
    public function file($file);

    /**
     * @param string $path
     * @return mixed
     */
    public function push($path = '');
}
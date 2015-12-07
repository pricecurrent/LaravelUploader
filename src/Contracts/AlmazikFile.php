<?php

namespace Almazik\LaravelUploader\Contracts;

interface AlmazikFile
{
    /**
     * @return mixed
     */
    public function getContents();

    /**
     * @return mixed
     */
    public function getFilename();
}
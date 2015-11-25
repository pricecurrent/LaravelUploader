<?php

namespace Almazik\LaravelUploader\Contracts;

interface AlmazikFile
{
    public function getContents();

    public function getFilename();
}
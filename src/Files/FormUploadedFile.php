<?php

namespace Almazik\LaravelUploader\Files;

use File;
use Almazik\LaravelUploader\Contracts\AlmazikFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FormUploadedFile implements AlmazikFile
{
    protected $file;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function getContents()
    {
        return File::get($this->file);
    }

    public function getFilename()
    {
        return str_replace(' ', '_', time() . '_' . $this->file->getClientOriginalName());
    }
}

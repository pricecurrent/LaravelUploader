<?php

namespace Almazik\LaravelUploader\Files;

use File;
use Almazik\LaravelUploader\Contracts\AlmazikFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FormUploadedFile implements AlmazikFile
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return File::get($this->file);
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return str_replace(' ', '_', time() . '_' . $this->file->getClientOriginalName());
    }
}

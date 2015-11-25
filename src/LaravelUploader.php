<?php

namespace Almazik\LaravelUploader;

use File;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Factory;
use Almazik\LaravelUploader\Contracts\Uploader;
use Almazik\LaravelUploader\Contracts\AlmazikFile;
use Almazik\LaravelUploader\Files\FormUploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LaravelUploader implements Uploader
{
    protected $storage;

    /**
     * @var  AlmazikFile $file
     */
    protected $file;

    protected $fullPath;

    protected $fileContents;
    protected $filename;
    protected $filePath;
    protected $acl = 'public';

    public function __construct(Factory $storage)
    {
        $this->storage = $storage;
    }

    public function file($file)
    {
        if ($file instanceof UploadedFile) {
            $this->file = new FormUploadedFile($file);
        }

        return $this;
    }

    public function push($path = '')
    {
        if (! $this->getFileContents()) {
            $this->fileContents($this->file->getContents());
        }

        if (! $this->getFilename()) {
            $this->filename($this->file->getFilename());
        }

        if (! $this->getFilePath()) {
            $this->filePath($path);
        }

        $this->upload();
    }

    protected function upload()
    {
        $this->storage->put(
            $this->fullPath(),
            $this->fileContents,
            $this->acl
        );
    }

    public function fileContents($contents)
    {
        $this->fileContents = $contents;

        return $this;
    }

    public function filename($name)
    {
        $this->filename = $name;

        return $this;
    }

    public function filePath($path)
    {
        $this->filePath = $path;

        return $this;
    }

    public function acl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    public function getFileContents()
    {
        return $this->fileContents;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getFullPath()
    {
        return $this->fullPath;
    }

    private function fullPath()
    {
        return $this->fullPath = $this->filePath . '/'. $this->filename;
    }
}

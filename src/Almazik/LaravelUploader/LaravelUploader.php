<?php

namespace Almazik\LaravelUploader;

use File;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Almazik\LaravelUploader\Uploader;
use Illuminate\Contracts\Filesystem\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LaravelUploader implements Uploader
{
    protected $storage;

    protected $fileContents;
    protected $filename;
    protected $filePath;
    protected $acl = 'public';

    public function __construct(Factory $storage)
    {
        $this->storage = $storage;
    }

    public function go($file, $path = '')
    {
        if (! $this->getFileContents()) {
            $this->buildFileContents($file);
        }

        if (! $this->getFilename()) {
            $this->buildFilename($file);
        }

        if (! $this->getFilePath()) {
            $this->filePath($path);
        }

        $this->upload();
    }

    protected function upload()
    {
        $this->storage->put(
            $this->filePath . '/'. $this->filename,
            $this->fileContents,
            $this->acl
        );
    }

    protected function buildFileContents($file)
    {
        if ($file instanceof UploadedFile) {
            $this->fileContents = File::get($file);
        }
    }

    protected function buildFilename($file)
    {
        if ($file instanceof UploadedFile) {
            $this->filename = str_replace(' ', '_', time() . '_' . $file->getClientOriginalName());
        }
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
}

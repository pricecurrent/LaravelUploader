<?php

namespace Almazik\LaravelUploader;

use App;
use File;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Factory;
use Almazik\LaravelUploader\Contracts\Uploader;
use Almazik\LaravelUploader\Contracts\AlmazikFile;
use Almazik\LaravelUploader\Files\FormUploadedFile;
use Almazik\LaravelUploader\Files\Base64EncodedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Almazik\LaravelUploader\Exceptions\InvalidFileTypeException;

class LaravelUploader implements Uploader
{
    /**
     * @var Factory
     */
    protected $storage;

    /**
     * @var  AlmazikFile $file
     */
    protected $file;

    /**
     * @var
     */
    protected $fullPath;

    /**
     * @var
     */
    protected $fileContents;
    /**
     * @var
     */
    protected $filename;
    /**
     * @var
     */
    protected $filePath;
    /**
     * @var FileUtility
     */
    protected $fileUtility;
    /**
     * @var string
     */
    protected $acl = 'public';

    /**
     * @param Factory $storage
     * @param FileUtility $fileUtility
     */
    public function __construct(Factory $storage, FileUtility $fileUtility)
    {
        $this->storage = $storage;
        $this->fileUtility = $fileUtility;
    }

    /**
     * @param $file
     * @return $this
     * @throws InvalidFileTypeException
     */
    public function file($file)
    {
        if ($file instanceof UploadedFile) {
            $this->file = new FormUploadedFile($file);

            return $this;
        }

        if ($this->fileUtility->isBase64Encoded($file)) {
            $this->file = App::make(Base64EncodedFile::class, [$file]);

            return $this;
        }

        throw new InvalidFileTypeException('Invalid File Type Provided');
    }

    /**
     * @param string $path
     * @return mixed
     */
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

        return $this->upload();
    }

    /**
     * @return mixed
     */
    protected function upload()
    {
        return $this->storage->put(
            $this->fullPath(),
            $this->fileContents,
            $this->acl
        );
    }

    /**
     * @param $contents
     * @return $this
     */
    public function fileContents($contents)
    {
        $this->fileContents = $contents;

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function filename($name)
    {
        $this->filename = $name;

        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function filePath($path)
    {
        $this->filePath = $path;

        return $this;
    }

    /**
     * @param $acl
     * @return $this
     */
    public function acl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileContents()
    {
        return $this->fileContents;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @return mixed
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * @return string
     */
    private function fullPath()
    {
        return $this->fullPath = $this->filePath . '/'. $this->filename;
    }
}

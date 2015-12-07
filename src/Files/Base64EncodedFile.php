<?php

namespace Almazik\LaravelUploader\Files;

use Almazik\LaravelUploader\FileUtility;
use Almazik\LaravelUploader\Contracts\AlmazikFile;

class Base64EncodedFile implements AlmazikFile
{
    /**
     * @var
     */
    protected $file;
    /**
     * @var FileUtility
     */
    protected $fileUtility;

    /**
     * @param $file
     * @param FileUtility $fileUtility
     */
    public function __construct($file, FileUtility $fileUtility)
    {
        $this->file = $file;
        $this->fileUtility = $fileUtility;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return base64_decode($this->file);
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        $contents = base64_decode($this->file);

        $mimeType = $this->getMimeType($contents);

        $extension = $this->fileUtility->lookupExtension($mimeType);

        return $this->buildFullFilename($extension);
    }

    /**
     * @param $contents
     * @return string
     */
    private function getMimeType($contents)
    {
        $finfo = new \finfo(FILEINFO_MIME);

        return $mimeType = $finfo->buffer($contents, FILEINFO_MIME_TYPE);
    }

    /**
     * @param $extension
     * @return string
     */
    private function buildFullFilename($extension)
    {
        return uniqid() . '_' . '.' . $extension;
    }
}
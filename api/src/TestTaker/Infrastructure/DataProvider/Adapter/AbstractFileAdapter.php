<?php

namespace App\TestTaker\Infrastructure\DataProvider\Adapter;


use App\TestTaker\App\Support\File;

/**
 * Class AbstractFileAdapter
 * @package App\TestTaker\Infrastructure\DataProvider\Adapter
 */
abstract class AbstractFileAdapter extends AbstractAdapter
{
    /** @var array */
    protected const SUPPORTED_EXTENSION = [];

    /** @var array */
    protected const SUPPORTED_MIMETYPE = [];

    /** @var File */
    protected $file;

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param string $filePath
     * @return self
     */
    public function setFile(string $filePath): self
    {
        $this->file = new File($filePath);
        return $this;
    }

    /**
     * @param array $options
     * @return bool
     */
    public function canHandleOptions(array $options): bool
    {
        if (!isset($options['path']) || !is_readable($options['path'])) {
            return false;
        }

        $this->setFile($options['path']);

        return $this->isSupported($this->file->getExtension(), $this->file->getFileMimeType());
    }

    /**
     * @param string $extension
     * @param string $mimetype
     * @return bool
     */
    protected function isSupported(string $extension, string $mimetype): bool
    {
        return in_array($extension, static::SUPPORTED_EXTENSION, true)
            &&  in_array($mimetype, static::SUPPORTED_MIMETYPE, true);
    }
}
<?php

namespace App\TestTaker\App\Support;

/**
 * Class File
 * @package App\TestTaker\App\Support
 */
class File extends \SplFileObject
{
    /**
     * @return string
     */
    public function getFileMimeType(): string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo,$this->getRealPath());
        finfo_close($finfo);

        return $mimetype;
    }
}
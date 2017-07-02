<?php

namespace App\Traits;


trait LogFile
{

    public static function logDirPath()
    {
        return rtrim(config('log.dir_path'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public static function defaultFilePath()
    {
        return ltrim(config('log.default_file'), DIRECTORY_SEPARATOR);
    }

}
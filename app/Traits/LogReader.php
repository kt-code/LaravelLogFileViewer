<?php

namespace App\Traits;


use App\Exceptions\LogReaderException;

trait LogReader
{
    use LogFile;

    /**
     * Get full contents of the file
     * @param string $path
     * @return array
     * @throws LogReaderException
     */
    public function getContents(string $path)
    {
        $logDirPath = self::logDirPath();
        $path = ltrim($path, DIRECTORY_SEPARATOR);
        if (empty($path))
            throw new LogReaderException('Invalid file path');

        //--Filepath is based on the server's log folder which is defined in .env
        $fullpath = $logDirPath . $path;

        if(\File::exists($fullpath) == false)
            throw new LogReaderException('File not exist');

        //--Only text file allowed
        $mime = \File::mimeType($fullpath);
        if (str_contains($mime, 'text') == false)
            throw new LogReaderException('Invalid file type');

        //--File must not be empty
        $size = \File::size($fullpath);
        if ($size == 0)
            throw new LogReaderException('Empty file');

        $contents = \File::get($fullpath);
        $contents = explode(PHP_EOL, $contents);

        return $contents;
    }

    /**
     * Extract a slice of the content
     * @param array $contents
     * @param int $start
     * @param int $length
     * @return array
     * @throws LogReaderException
     */
    public function getLines(array $contents, int $start, int $length)
    {
        $lines = [];

        $slice = array_slice($contents, $start, $length);
        if (empty($slice))
            throw new LogReaderException('No contents.');

        for ($i = 0; $i < count($slice); $i++) {
            $line = $slice[$i];
            //-Ignore empty line
            if ($line)
                $lines[] = [($start + $i + 1), $line];
        }

        return $lines;
    }


}
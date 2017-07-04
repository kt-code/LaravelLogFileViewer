<?php

class LogReaderTest extends TestCase
{
    use \App\Traits\LogReader;

    /**
     * @return void
     */
    public function testLogDirPath()
    {
        $v = self::logDirPath();
        $this->assertNotEmpty($v, 'Please define LOG_DIR_PATH in .env');
    }

    /**
     * @return void
     */
    public function testDefaultFilePath()
    {
        $v = self::defaultFilePath();
        $this->assertNotEmpty($v, 'Please define LOG_DEFAULT_FILE in .env');
    }

    /**
     * @depends testLogDirPath
     * @depends testDefaultFilePath
     * @return void
     */
    public function testGetContents()
    {
        $contents = $this->getContents(self::defaultFilePath());
        $this->assertNotEmpty($contents);
    }

    /**
     * @depends testGetContents
     * @return void
     */
    public function testGetLines()
    {
        $contents = $this->getContents(self::defaultFilePath());

        $start = 0;
        $length = 10;
        $range = range($start, count($contents) - 1, $length);
        foreach ($range as $n) {
            $lines = $this->getLines($contents, $n, $length);
            $this->assertNotEmpty($lines);
        }
    }

}

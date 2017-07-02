<?php

class LogReaderTest extends TestCase
{
    use \App\Traits\LogReader;

    /**
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
        $range = range($start, count($contents)-1, $length);
        // print_r($range);
        // exit();
        foreach ($range as $n) {
            $lines = $this->getLines($contents, $n, $length);
            $this->assertNotEmpty($lines);
            // $this->assertArraySubset($n, $lines);
            // $this->assertArrayNotHasKey($n + $length, $lines);
        }
    }

}

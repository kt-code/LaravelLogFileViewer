<?php

class LogViewerTest extends TestCase
{
    // /**
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

    /**
     * @return void
     */
    public function testIndexPage()
    {
        $this->visit('/')
            ->see('Log File Viewer');
    }

    /**
     * @return void
     */
    public function testAjaxToRetrieveEmptyFilePath()
    {
        $params = [
            'path' => '',
        ];
        $this->get('/log?' . http_build_query($params))
            // ->seeJson()
            ->see('ERROR');
    }

    /**
     * @return void
     */
    public function testAjaxToRetrieveInvalidFile()
    {
        $params = [
            'path' => '/var/tmp/filename.log',
        ];
        $this->get('/log?' . http_build_query($params))
            ->see('ERROR');
    }

    /**
     * @return void
     */
    public function testAjaxToRetrieveImageFile()
    {
        $params = [
            'path' => '../tile.png',
        ];
        $this->get('/log?' . http_build_query($params))
            ->see('ERROR');
    }

    /**
     * @return void
     */
    public function testAjaxToRetrieveEmptyFile()
    {
        $params = [
            'path' => '../tile.png',
        ];
        $this->get('/log?' . http_build_query($params))
            ->see('ERROR');
    }

    /**
     * @return void
     */
    public function testAjaxToRetrieveFirstPage()
    {
        $params = [
            'path' => $this->getCorrectFilePath(),
        ];
        // dd(http_build_query($params));
        $this->get('/log?' . http_build_query($params))
            ->dontSee('ERROR');
    }

    /**
     * @depends testAjaxToRetrieveFirstPage
     * @return void
     */
    public function testAjaxToRetrieveSecondPage()
    {
        $params = [
            'path' => $this->getCorrectFilePath(),
            'start' => $this->getLengthPerPage() + 1,
        ];
        // dd(http_build_query($params));
        $this->get('/log?' . http_build_query($params))
            ->dontSee('ERROR');
    }

    /**
     * @depends testAjaxToRetrieveSecondPage
     * @return void
     */
    public function testAjaxToRetrieveThirdPage()
    {
        $params = [
            'path' => $this->getCorrectFilePath(),
            'start' => $this->getLengthPerPage() * 2 + 1,
        ];
        // dd(http_build_query($params));
        $this->get('/log?' . http_build_query($params))
            ->dontSee('ERROR');
    }



    //-------------------------
    //--Protected Functions--//
    //-------------------------

    protected function getCorrectFilePath()
    {
        return config('log.default_file');
    }

    protected function getLengthPerPage()
    {
        return 10;
    }
}

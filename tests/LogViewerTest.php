<?php

class LogViewerTest extends TestCase
{
    use \App\Traits\LogFile;

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
            ->see('ALERT');
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
            ->see('ALERT');
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
            ->see('ALERT');
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
            ->see('ALERT');
    }

    /**
     * @return void
     */
    public function testAjaxToRetrieveFirstPage()
    {
        $params = [
            'path' => $this->getValidFilePath(),
        ];
        $this->get('/log?' . http_build_query($params))
            ->dontSee('ALERT');
    }

    /**
     * @depends testAjaxToRetrieveFirstPage
     * @return void
     */
    public function testAjaxToRetrieveSecondPage()
    {
        $params = [
            'path' => $this->getValidFilePath(),
            'start' => $this->getLengthPerPage() + 1,
        ];
        $this->get('/log?' . http_build_query($params))
            ->dontSee('ALERT');
    }

    /**
     * @depends testAjaxToRetrieveSecondPage
     * @return void
     */
    public function testAjaxToRetrieveThirdPage()
    {
        $params = [
            'path' => $this->getValidFilePath(),
            'start' => $this->getLengthPerPage() * 2 + 1,
        ];
        $this->get('/log?' . http_build_query($params))
            ->dontSee('ALERT');
    }



    //-------------------------
    //--Protected Functions--//
    //-------------------------

    protected function getValidFilePath()
    {
        return self::defaultFilePath();
    }

    protected function getLengthPerPage()
    {
        return 10;
    }
}

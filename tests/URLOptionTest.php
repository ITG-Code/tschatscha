<?php


class URLOptionTest extends PHPUnit_Framework_TestCase
{
    public function testValidUrl()
    {
        require_once 'app/Helper/URLOption.php';
        URLOption::parse([
            'blog',
            'banan',
            'page',
            '2',
            'limit',
            '65'
        ]);
        $this->assertEquals(2, URLOption::$page);
        $this->assertEquals(65, URLOption::$limit);
        URLOption::parse([
            'kappa',
            'page',
            '2.4',
            'limit',
            '7.4'
        ]);
        $this->assertEquals(2, URLOption::$page);
        $this->assertEquals(7, URLOption::$limit);
    }
}
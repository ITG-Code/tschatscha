<?php

class AppTest extends PHPUnit_Framework_TestCase
{
    public function testParseUrl()
    {
        require_once 'app/Core/App.php';
        $testUrls = ['/', 'blog/kappa/', '//', 'äöåöäöåöäöåöä', '\\\\\n',''];
        foreach ($testUrls as $url) {
            $parsedUrl = App::parseUrl($url);
            if(!is_array($parsedUrl)){
                throw new Exception('URL not parsed to array');
            }
        }
    }
}
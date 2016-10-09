<?php


class AppTest extends PHPUnit_Framework_TestCase
{
    public function testParseUrl(){
      $testUrls = ['/','blog/kappa/','//','äöåöäöåöäöåöä','\\\\\n'];
      foreach($testUrls as $url){
        App::parseUrl($url);
      }
    }
}
<?php


class AppTest
{
    public function testParseUrl(){
      $testUrls = ['/','blog/kappa/','//','äöåöäöåöäöåöä','\\\\\n'];
      foreach($testUrls as $url){
        App::parseUrl($url);
      }
    }
}
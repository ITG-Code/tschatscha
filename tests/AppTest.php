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
    public function testVisitPages(){
        require_once 'app/init.php';

        $controllers = scandir('app/Controller');
        unset($controllers[0]);
        unset($controllers[1]);
        $controllers = array_values($controllers);
        foreach ($controllers as $controller){
            $controller = explode('.', $controller)[0];
            require_once "app/Controller/$controller.php";
            $controllerMethods  = get_class_methods($controller);

            new App("$controller/index");
            foreach ($controllerMethods as $methodName){
                new App("$controller/$methodName");
            }
        }
    }
}
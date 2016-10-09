<?php

class App
{

    private $controller = "home";
    private $method = "index";
    private $param = [];


    public function __construct()
    {
        $url = $this->parseUrl();
        if (file_exists('app/Controller/' . ucfirst($url[0]) . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $this->controller = ucfirst($this->controller);
        require_once 'app/Controller/' . $this->controller . '.php';
        $this->controller = new $this->controller();

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->param = $url ? array_values($url) : [];
        call_user_func([$this->controller, $this->method], $this->param);
    }

    public static function parseUrl(string $url = null) : array
    {
        if (!isset($url)) {
            $url = (isset($_GET['url'])) ? $_GET['url'] : "";
        }
        return explode(
            '/',
            filter_var(
                str_replace(
                    " ",
                    "-",
                    trim($url, '/')
                ),
                FILTER_SANITIZE_URL
            )
        );
    }
}

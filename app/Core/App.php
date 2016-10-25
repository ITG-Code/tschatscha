<?php

class App
{

    private $controller = "home";
    private $method = "index";
    private $param = [];
    private $blogName = '';

    public function __construct(string $url = '')
    {
        // Gets what's behind the domain in the url
        // domain.tld/this/is/what/you/get
        if (empty($url) && isset($_GET['url'])) {
            $url = $_GET['url'];
        }
        // Explodes the url by '/'
        $url = $this->parseUrl($url);
        // Tries to find the controller requested by user
        // If the controller doesn't exist it tries to find a blog with that name
        if (file_exists('app/Controller/' . ucfirst($url[0]) . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
            $url = $url ? array_values($url) : [];
        }
        if (isset($url[0]) && self::blogExists($url[0])) {
            $this->controller = "blog";
            $this->blogName = $url[0];
            unset($url[0]);
            $url = $url ? array_values($url) : [];
        }
        // Initiates the chosen controller
        $this->controller = ucfirst($this->controller);
        require_once 'app/Controller/' . $this->controller . '.php';
        if ($this->controller == "Blog" && !empty($this->blogName)) {
            $this->controller = new $this->controller($this->blogName);
        } else {
            $this->controller = new $this->controller();
        }
        // Calls the function that is after the second slash in the url
        if (isset($url[0])) {
            if (method_exists($this->controller, $url[0])) {
                $this->method = $url[0];
                unset($url[0]);
                $this->param = $url ? array_values($url) : [];
            }
        }
        call_user_func([$this->controller, $this->method], $this->param);
    }

    public static function parseUrl(string $url) : array
    {
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

    /**
     * @param string $name
     * @return bool
     */
    public static function blogExists(string $name) : bool
    {
        require_once 'app/Model/BlogModel.php';
        return BlogModel::exists($name);
    }
}

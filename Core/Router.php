<?php

namespace Core;

class Router
{
    protected $routes = [];

    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller
        ];
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                return $this->callAction($route['controller']);
            }
        }

        $this->abort();
    }

    protected function callAction($controller)
    {
        [$class, $action] = explode('@', $controller);

        $class = "Http\\Controllers\\$class";

        return (new $class)->$action();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        $path = BASE_PATH . "views/{$code}.view.php";

        if (file_exists($path)) {
            require $path;
        }

        die();
    }
}
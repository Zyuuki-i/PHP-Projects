<?php
namespace App;

class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch($method, $path)
    {
        $path = parse_url($path, PHP_URL_PATH);

        foreach ($this->routes as $route) {

            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            // Hỗ trợ dynamic param
            $pattern = preg_replace('/:([a-zA-Z0-9_]+)/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#u';

            if (preg_match($pattern, $path, $matches)) {

                // Lấy param
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_numeric($key)) {
                        $params[$key] = $value;
                    }
                }

                $callback = $route['callback'];

                // Trường hợp callback = "Controller@method"
                if (is_string($callback) && str_contains($callback, '@')) {
                    [$class, $method] = explode('@', $callback);
                    $class = "App\\Controller\\$class";
                    $controller = new $class();
                    return call_user_func_array([$controller, $method], $params);
                }

                // Trường hợp callback là function
                $ref = new \ReflectionFunction($callback);
                if ($ref->getNumberOfParameters() > 0) {
                    return call_user_func($callback, $params);
                }
                return call_user_func($callback);
            }
        }

        http_response_code(404);
        return '<h1 style="color:red; text-align:center">404 - Not Found</h1>';
    }
}

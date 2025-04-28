<?php
namespace App;

class Router {
    private $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');

        foreach ($this->routes[$method] as $route => $callback) {
            $route = trim($route, '/');
            $routePattern = preg_replace('/\/:(\w+)/', '/(?P<$1>[^/]+)', $route);
            $routePattern = "@^" . $routePattern . "$@D";

            if (preg_match($routePattern, $url, $matches)) {
                array_shift($matches);
                
                if (is_array($callback)) {
                    $controller = new $callback[0];
                    $method = $callback[1];
                    return call_user_func_array([$controller, $method], $matches);
                }
                
                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
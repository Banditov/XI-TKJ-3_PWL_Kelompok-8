<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, string $controller, string $function)
    {
        $this->routes[] = [
            'method'     => strtoupper($method),
            'uri'        => $uri,
            'controller' => $controller,
            'function'   => $function
        ];
    }

    public function run()
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $pattern = '#^' . preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route['uri']) . '$#';

            if ($route['method'] !== $method) {
                continue;
            }

            if (!preg_match($pattern, $uri, $matches)) {
                continue;
            }

            array_shift($matches);

            require_once __DIR__ . '/../controllers/' . $route['controller'] . '.php';

            $controller = new ('App\\Controllers\\' . $route['controller'])();

            call_user_func_array([$controller, $route['function']], $matches);
            return;
        }

        http_response_code(404);
        (new \App\Controllers\ErrorController())->error404();
        exit;
    }
}
<?php
namespace App\Core;

class Router
{
    private array $routes = [];
    private static array $current_route = [
        'controller' => null,
        'action' => null,
        'params' => []
    ];

    public function add(string $method, string $uri, string $controller, string $function)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'function' => $function
        ];
    }

    private function setCurrentRoute(string $controller, string $action, array $params = [])
    {
        self::$current_route = [
            'controller' => strtolower($controller),
            'action' => strtolower($action),
            'params' => $params
        ];
    }

    public static function is(string $controller, ?string $action = null): bool
    {
        if ($action === null) {
            return self::$current_route['controller'] === strtolower($controller);
        }
        return self::$current_route['controller'] === strtolower($controller) && 
               self::$current_route['action'] === strtolower($action);
    }

    public static function isAny(array $routes): bool
    {
        foreach ($routes as $route) {
            if (is_array($route) && count($route) >= 2) {
                $action = $route[1] ?? null;
                if (self::is($route[0], $action)) {
                    return true;
                }
            } elseif (is_string($route)) {
                if (self::is($route)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getCurrentRoute(): array
    {
        return self::$current_route;
    }

    private function show404()
    {
        http_response_code(404);

        $this->setCurrentRoute('ErrorController', 'error404', []);

        $controllerFile = __DIR__ . '/../controllers/ErrorController.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = 'App\\Controllers\\ErrorController';
            $controller = new $controllerClass();

            call_user_func([$controller, 'error404']);
        } else {
            echo "<h1>404 - Page Not Found</h1>";
        }
        exit;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $pattern = str_replace(
                '{id}',
                '([0-9]+)',
                $route['uri']
            );
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                $this->setCurrentRoute(
                    $route['controller'], 
                    $route['function'], 
                    $matches
                );

                require_once __DIR__ . '/../controllers/' . $route['controller'] . '.php';

                $controllerClass = 'App\\Controllers\\' . $route['controller'];
                $controller = new $controllerClass();

                call_user_func_array([$controller, $route['function']], $matches);
                return;
            }
        }

        $this->show404();
    }
}
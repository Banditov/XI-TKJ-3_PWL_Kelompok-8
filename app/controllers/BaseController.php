<?php
namespace App\Controllers;

use App\Core\Router;

class BaseController
{
    protected function render($view, $data = [])
    {
        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view . '/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/render.php';
    }

    protected function isPage(string $controller, ?string $action = null): bool
    {
        return Router::is($controller, $action);
    }

    protected function isAnyPage(array $routes): bool
    {
        return Router::isAny($routes);
    }

    protected function getCurrentRoute(): array
    {
        return Router::getCurrentRoute();
    }

    protected function setData(array $data, string $key, $value): array
    {
        $data[$key] = $value;
        return $data;
    }
}
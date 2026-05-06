<?php
session_start();

spl_autoload_register(function ($class) {
    $class = str_replace('App\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $file  = __DIR__ . '/../app/' . strtolower($class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . '/../app/resources/icons/icon.php';

use App\Core\Router;

$router = new Router();

$router->add('GET', '/', 'IntroController', 'index');

$router->add('GET', '/login', 'AuthController', 'login');
$router->add('GET', '/logout', 'AuthController', 'logout');

$router->add('GET', '/posts', 'PostController', 'index');
$router->add('GET', '/posts/create', 'PostController', 'create');
$router->add('GET', '/posts/{id}', 'PostController', 'show');

$router->add('POST', '/posts', 'PostController', 'store');
$router->add('POST', '/login', 'AuthController', 'authenticate');

$router->run();
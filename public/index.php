<?php
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/controllers/ErrorController.php';
require_once __DIR__ . '/../app/models/Post.php';
require_once __DIR__ . '/../app/resources/icons/icon.php';

use App\Core\Router;

$router = new Router();

$router->add('GET', '/', 'IntroController', 'index');

$router->add('GET', '/login', 'AuthController', 'login');

$router->add('GET', '/posts', 'PostController', 'index');
$router->add('GET', '/posts/create', 'PostController', 'create');
$router->add('GET', '/posts/{id}', 'PostController', 'show');

$router->run();
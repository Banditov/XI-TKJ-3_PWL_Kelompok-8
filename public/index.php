<?php
    require_once __DIR__ . '/../app/core/Router.php';
    require_once __DIR__ . '/../app/controllers/BaseController.php';
    use App\Core\Router;

    $router = new Router();

    $router->add('GET', '/', 'ExtendController', 'intro');
    $router->add('GET', '/test', 'ExtendController', 'test');

    $router->run();
?>
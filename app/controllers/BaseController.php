<?php
namespace App\Controllers;
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
}
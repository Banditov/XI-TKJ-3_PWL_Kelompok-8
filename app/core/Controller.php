<?php
namespace App\Core;

class Controller
{
    public function view(string $view, array $data = [])
    {
        $view = str_replace('.', '/', $view);

        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../views/layouts/app.php';
    }
}
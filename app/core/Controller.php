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

    protected function requireLogin()
    {
        if (!isset($_SESSION['account_id'])) {
            header('Location: /login');
            exit;
        }
    }

    protected function requireAdmin()
    {
        $this->requireLogin();

        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            header('Location: /posts');
            exit;
        }
    }
}
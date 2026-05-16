<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Account;

class AuthController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['account_id'])) {
            header('Location: /posts');
            exit;
        }
        $this->view('login.index');
    }

    public function authenticate()
    {
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $keep     = isset($_POST['keep']);

        $accountModel = new Account();
        $account      = $accountModel->getByEmail($email);

        if (!$account) {
            header('Location: /login?error=invalid');
            exit;
        }

        $valid = password_verify($password, $account['password'])
                || $password === $account['password'];

        if (!$valid) {
            header('Location: /login?error=invalid');
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['account_id'] = $account['id'];
        $_SESSION['account_name'] = $account['name'];
        $_SESSION['is_admin'] = $account['is_admin'];
        $_SESSION['is_dark'] = $account['is_dark'] ?? 0;
        $_SESSION['is_dyslexic'] = $account['is_dyslexic'] ?? 0;

        if ($keep) {
            $expiry = time() + (60 * 60 * 24 * 30); // 30 days
            setcookie(session_name(), session_id(), $expiry, '/');
        }

        header('Location: /posts');
        exit;
    }

    public function logout()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        setcookie('remember_token', '', time() - 3600, '/');

        session_destroy();

        echo '<script>
            localStorage.removeItem("darkMode");
            localStorage.removeItem("dyslexicMode");
            window.location.href = "/login";
        </script>';
        exit;
    }
}
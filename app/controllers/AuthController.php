<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Account;

class AuthController extends Controller
{
    public function login()
    {
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

        $_SESSION['account_id']   = $account['id'];
        $_SESSION['account_name'] = $account['name'];
        $_SESSION['is_admin']     = $account['is_admin'];

        if ($keep) {
            $expiry = time() + (60 * 60 * 24 * 30); // 30 days
            setcookie(session_name(), session_id(), $expiry, '/');
        }

        header('Location: /posts');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
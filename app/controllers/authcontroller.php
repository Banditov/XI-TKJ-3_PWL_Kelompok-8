<?php
namespace app\controllers;

use app\core\controller;
use app\models\account;

class authcontroller extends controller
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
        $email = $_POST['email'];
        $password = $_POST['password'];
        $keep = isset($_POST['keep']);

        $accountModel = new account();
        $account = $accountModel->getByEmail($email);

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
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
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

    public function register()
    {
        $this->requireAdmin();

        $classModel = new \app\models\classes();
        $classes = $classModel->getAllClasses();

        $this->view('admin.register', [
            'classes' => $classes
        ]);
    }

    public function createUser()
    {
        $this->requireAdmin();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $classId = intval($_POST['class_id'] ?? 0);
        $isAdmin = isset($_POST['is_admin']) ? 1 : 0;

        if (empty($name)) {
            $_SESSION['error'] = 'Name is required';
            header("Location: /admin/register");
            exit;
        }

        if (empty($email)) {
            $_SESSION['error'] = 'Email is required';
            header("Location: /admin/register");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Invalid email format';
            header("Location: /admin/register");
            exit;
        }

        if (empty($password)) {
            $_SESSION['error'] = 'Password is required';
            header("Location: /admin/register");
            exit;
        }

        if (strlen($password) < 4) {
            $_SESSION['error'] = 'Password must be at least 4 characters';
            header("Location: /admin/register");
            exit;
        }

        if ($classId <= 0) {
            $_SESSION['error'] = 'Please select a class';
            header("Location: /admin/register");
            exit;
        }

        $accountModel = new account();

        $existingUser = $accountModel->getByEmail($email);
        if ($existingUser) {
            $_SESSION['error'] = 'Email already exists';
            header("Location: /admin/register");
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userId = $accountModel->createUser($name, $email, $hashedPassword, $classId, $isAdmin);

        if (!$userId) {
            $_SESSION['error'] = 'Failed to create user';
            header("Location: /admin/register");
            exit;
        }

        if (!empty($_FILES['avatar']['name'])) {
            $this->uploadAvatar($_FILES['avatar'], $userId);
        }

        $_SESSION['success'] = 'User created successfully!';
        header("Location: /admin/users");
        exit;
    }

    public function users()
    {
        $this->requireAdmin();

        $accountModel = new account();
        $users = $accountModel->getAllUsers();

        $this->view('admin.users', [
            'users' => $users
        ]);
    }

    public function editUser(string $id)
    {
        $this->requireAdmin();

        $accountModel = new account();
        $user = $accountModel->getById(intval($id));

        if (!$user) {
            header("Location: /admin/users");
            exit;
        }

        $classModel = new \app\models\classes();
        $classes = $classModel->getAllClasses();

        $this->view('admin.edit', [
            'user' => $user,
            'classes' => $classes
        ]);
    }

    public function updateUser(string $id)
    {
        $this->requireAdmin();

        $userId = intval($id);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $classId = intval($_POST['class_id'] ?? 0);
        $isAdmin = isset($_POST['is_admin']) ? 1 : 0;

        if (empty($name)) {
            $_SESSION['error'] = 'Name is required';
            header("Location: /admin/users/$id/edit");
            exit;
        }

        if (empty($email)) {
            $_SESSION['error'] = 'Email is required';
            header("Location: /admin/users/$id/edit");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Invalid email format';
            header("Location: /admin/users/$id/edit");
            exit;
        }

        if ($classId <= 0) {
            $_SESSION['error'] = 'Please select a class';
            header("Location: /admin/users/$id/edit");
            exit;
        }

        $accountModel = new account();

        $existingUser = $accountModel->getByEmail($email);
        if ($existingUser && $existingUser['id'] != $userId) {
            $_SESSION['error'] = 'Email already exists for another user';
            header("Location: /admin/users/$id/edit");
            exit;
        }

        if (!empty($_FILES['avatar']['name'])) {
            $this->deleteAvatar($userId);
            $this->uploadAvatar($_FILES['avatar'], $userId);
        }

        $result = $accountModel->updateUser($userId, $name, $email, $classId, $isAdmin);

        if (!empty($password)) {
            if (strlen($password) < 4) {
                $_SESSION['error'] = 'Password must be at least 4 characters';
                header("Location: /admin/users/$id/edit");
                exit;
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $accountModel->updatePassword($userId, $hashedPassword);
        }

        if ($result) {
            $_SESSION['success'] = 'User updated successfully!';
            header("Location: /admin/users");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update user';
            header("Location: /admin/users/$id/edit");
            exit;
        }
    }

    public function deleteUser(string $id)
    {
        $this->requireAdmin();

        $userId = intval($id);

        if ($userId == $_SESSION['account_id']) {
            $_SESSION['error'] = 'You cannot delete your own account';
            header("Location: /admin/users");
            exit;
        }

        $accountModel = new account();

        $this->deleteAvatar($userId);

        $result = $accountModel->deleteUser($userId);

        if ($result) {
            $_SESSION['success'] = 'User deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }

        header("Location: /admin/users");
        exit;
    }

    private function uploadAvatar($file, $accountId)
    {
    error_log("=== uploadAvatar called ===");
    error_log("File data: " . print_r($file, true));
    error_log("Account ID: " . $accountId);
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 10 * 1024 * 1024;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if (!in_array($file['type'], $allowed)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $accountId . '.' . $ext;

        $uploadDir = __DIR__ . '/../../public/assets/image/account/';

        if (!is_dir($uploadDir)) {
            $uploadDir = __DIR__ . '/../../assets/image/account/';
        }

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $pattern = $uploadDir . $accountId . '.*';
        $existingFiles = glob($pattern);
        foreach ($existingFiles as $existingFile) {
            if (is_file($existingFile)) {
                unlink($existingFile);
            }
        }

        $destination = $uploadDir . $filename;

        return move_uploaded_file($file['tmp_name'], $destination);
    }

    private function deleteAvatar($accountId)
    {
        $uploadDir = __DIR__ . '/../../public/assets/image/account/';

        if (!is_dir($uploadDir) || !is_readable($uploadDir)) {
            $uploadDir = __DIR__ . '/../../assets/image/account/';
        }

        $pattern = $uploadDir . $accountId . '.*';
        $files = glob($pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
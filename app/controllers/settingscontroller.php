<?php
namespace app\controllers;

use app\core\controller;
use app\models\account;

class settingscontroller extends controller
{
    public function toggleDyslexic()
    {
        $this->requireLogin();

        $dyslexic = intval($_POST['dyslexic'] ?? 0);
        $_SESSION['is_dyslexic'] = $dyslexic;

        $accountModel = new account();
        $result = $accountModel->updatePreference($_SESSION['account_id'], 'is_dyslexic', $dyslexic);

        echo json_encode(['success' => $result]);
    }

    public function toggleDark()
    {
        $this->requireLogin();

        $dark = intval($_POST['dark'] ?? 0);
        $_SESSION['is_dark'] = $dark;

        $accountModel = new account();
        $result = $accountModel->updatePreference($_SESSION['account_id'], 'is_dark', $dark);

        echo json_encode(['success' => $result]);
    }
}
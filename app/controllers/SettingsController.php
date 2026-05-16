<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Account;

class SettingsController extends Controller
{
    public function toggleDyslexic()
    {
        $this->requireLogin();

        $dyslexic = intval($_POST['dyslexic'] ?? 0);
        $_SESSION['is_dyslexic'] = $dyslexic;

        $accountModel = new Account();
        $result = $accountModel->updatePreference($_SESSION['account_id'], 'is_dyslexic', $dyslexic);

        echo json_encode(['success' => $result]);
    }

    public function toggleDark()
    {
        $this->requireLogin();

        $dark = intval($_POST['dark'] ?? 0);
        $_SESSION['is_dark'] = $dark;

        $accountModel = new Account();
        $result = $accountModel->updatePreference($_SESSION['account_id'], 'is_dark', $dark);

        echo json_encode(['success' => $result]);
    }
}
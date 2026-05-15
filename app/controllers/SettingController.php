<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Account;

class SettingsController extends Controller
{
    public function toggleDyslexic()
    {
        if (!isset($_SESSION['account_id'])) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            return;
        }

        $dyslexic = intval($_POST['dyslexic'] ?? 0);
        $_SESSION['is_dyslexic'] = $dyslexic;

        $accountModel = new Account();
        $result = $accountModel->updatePreference($_SESSION['account_id'], 'is_dyslexic', $dyslexic);

        echo json_encode(['success' => $result]);
    }
}
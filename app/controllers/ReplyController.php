<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function store(string $postId, string $commentId)
    {
        $description = trim($_POST['description'] ?? '');
        $accountId   = $_SESSION['account_id'];

        if (empty($description)) {
            header("Location: /posts/$postId");
            exit;
        }

        $replyModel = new Reply();
        $replyModel->createReply($postId, $commentId, $accountId, $description);

        header("Location: /posts/$postId");
        exit;
    }
}
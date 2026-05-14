<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function store(string $postId, string $commentId)
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        $description = trim($_POST['description'] ?? '');

        if (empty($description)) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Reply cannot be empty']);
                return;
            }
            header("Location: /posts/$postId");
            exit;
        }

        $accountId = $_SESSION['account_id'];

        $replyModel = new Reply();
        $replyId = $replyModel->createReply($postId, $commentId, $accountId, $description);

        $reply = $replyModel->getReplyById($replyId);

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'reply' => [
                    'id' => $reply['id'],
                    'account_name' => $reply['account_name'],
                    'class_name' => $reply['class_name'],
                    'account_id' => $reply['account_id'],
                    'description' => htmlspecialchars($reply['description']),
                    'date' => $reply['date'],
                    'votes' => 0,
                    'user_vote' => 0
                ]
            ]);
            return;
        }

        header("Location: /posts/$postId");
        exit;
    }
}
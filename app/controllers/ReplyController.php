<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Notification;

class ReplyController extends Controller
{
    public function store(string $postId, string $commentId)
    {
        $this->requireLogin();

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

        $commentModel = new Comment();
        $comment = $commentModel->getCommentById($commentId);

        if ($comment && $comment['account_id'] != $accountId) {
            $notificationModel = new Notification();
            $notificationModel->createReplyNotification($comment['account_id'], $replyId);
        }

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

    public function delete(string $replyId)
    {
        $this->requireLogin();

        $replyModel = new Reply();
        $reply = $replyModel->getReplyById($replyId);

        if (!$reply) {
            header("Location: /posts");
            exit;
        }

        $isOwner = ($reply['account_id'] == $_SESSION['account_id']);
        $isAdmin = ($_SESSION['is_admin'] ?? 0) == 1;
        
        if (!$isOwner && !$isAdmin) {
            $_SESSION['error'] = 'You cannot delete this reply';
            header("Location: /posts/{$reply['post_id']}");
            exit;
        }

        $replyModel->deleteReplyById(intval($replyId));

        $_SESSION['success'] = 'Reply deleted successfully!';
        header("Location: /posts/{$reply['post_id']}");
        exit;
    }
}
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Notification;

class CommentController extends Controller
{
        public function store(string $postId)
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        $description = trim($_POST['description'] ?? '');

        if (empty($description)) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Comment cannot be empty']);
                return;
            }
            header("Location: /posts/$postId");
            exit;
        }

        $accountId = $_SESSION['account_id'];

        $commentModel = new Comment();
        $commentId = $commentModel->createComment($postId, $accountId, $description);

        try {
            $postModel = new Post();
            $post = $postModel->getPostById($postId);

            if ($post && isset($post['account_id']) && $post['account_id'] != $accountId) {
                $notificationModel = new Notification();
                $notificationModel->createCommentNotification($post['account_id'], $commentId);
            }
        } catch (\Exception $e) {
            error_log("Notification error: " . $e->getMessage());
        }

        $comment = $commentModel->getCommentById($commentId);

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'comment' => [
                    'id' => $comment['id'],
                    'account_name' => $comment['account_name'] ?? $_SESSION['account_name'],
                    'class_name' => $comment['class_name'] ?? '',
                    'account_id' => $comment['account_id'],
                    'description' => htmlspecialchars($comment['description']),
                    'date' => $comment['date'],
                    'votes' => 0,
                    'user_vote' => 0
                ]
            ]);
            return;
        }

        header("Location: /posts/$postId");
        exit;
    }

    public function vote(string $commentId)
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$isAjax) {
            $accountId = $_SESSION['account_id'];
            $vote = intval($_POST['vote']);

            if (in_array($vote, [1, -1])) {
                $voteModel = new \App\Models\Vote();
                $voteModel->voteComment(intval($commentId), intval($accountId), $vote);
            }

            $redirect = $_POST['redirect'] ?? '/posts';
            header("Location: $redirect");
            exit;
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['account_id'])) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            return;
        }

        $accountId = $_SESSION['account_id'];
        $vote = isset($_POST['vote']) ? intval($_POST['vote']) : null;

        if (!in_array($vote, [1, -1])) {
            echo json_encode(['success' => false, 'error' => 'Invalid vote']);
            return;
        }

        $voteModel = new \App\Models\Vote();
        $result = $voteModel->voteComment(intval($commentId), intval($accountId), $vote);

        $commentModel = new Comment();
        $comment = $commentModel->getCommentById(intval($commentId));

        echo json_encode([
            'success' => true,
            'new_votes' => (int)$comment['votes'],
            'new_user_vote' => $result
        ]);
        return;
    }
}
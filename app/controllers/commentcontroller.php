<?php
namespace app\controllers;

use app\core\controller;
use app\models\comment;
use app\models\post;
use app\models\notification;

class commentcontroller extends controller
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

        $commentModel = new comment();
        $commentId = $commentModel->createComment($postId, $accountId, $description);

        try {
            $postModel = new post();
            $post = $postModel->getPostById($postId);

            if ($post && isset($post['account_id']) && $post['account_id'] != $accountId) {
                $notificationModel = new notification();
                $notificationModel->createCommentNotification($post['account_id'], $commentId);
            }
        } catch (\Exception $e) {
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
                $voteModel = new \app\models\vote();
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

        $voteModel = new \app\models\vote();
        $result = $voteModel->voteComment(intval($commentId), intval($accountId), $vote);

        $commentModel = new comment();
        $comment = $commentModel->getCommentById(intval($commentId));

        echo json_encode([
            'success' => true,
            'new_votes' => (int) $comment['votes'],
            'new_user_vote' => $result
        ]);
        return;
    }

    public function delete(string $commentId)
    {
        $this->requireLogin();

        $commentModel = new comment();
        $comment = $commentModel->getCommentById($commentId);

        if (!$comment) {
            header("Location: /posts");
            exit;
        }

        $isOwner = ($comment['account_id'] == $_SESSION['account_id']);
        $isAdmin = ($_SESSION['is_admin'] ?? 0) == 1;

        if (!$isOwner && !$isAdmin) {
            $_SESSION['error'] = 'You cannot delete this comment';
            header("Location: /posts/{$comment['post_id']}");
            exit;
        }

        $commentModel->deleteCommentById(intval($commentId));

        $_SESSION['success'] = 'Comment deleted successfully!';
        header("Location: /posts/{$comment['post_id']}");
        exit;
    }
}
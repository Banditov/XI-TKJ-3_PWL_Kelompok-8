<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Post;

class VoteController extends Controller
{
    public function votePost(string $postId)
    {
        $this->requireLogin();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$isAjax) {
            $accountId = $_SESSION['account_id'];
            $vote = intval($_POST['vote']);

            if (!in_array($vote, [1, -1])) {
                header("Location: /posts");
                exit;
            }

            $voteModel = new Vote();
            $voteModel->votePost(intval($postId), intval($accountId), $vote);

            $redirect = $_POST['redirect'] ?? '/posts';
            header("Location: $redirect");
            exit;
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['account_id'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Not logged in'
            ]);
            return;
        }

        $accountId = $_SESSION['account_id'];
        $vote = isset($_POST['vote']) ? intval($_POST['vote']) : null;

        if (!in_array($vote, [1, -1])) {
            echo json_encode([
                'success' => false,
                'error' => 'Invalid vote value'
            ]);
            return;
        }

        $voteModel = new Vote();
        $result = $voteModel->votePost(intval($postId), intval($accountId), $vote);

        $postModel = new Post();
        $post = $postModel->getPostById(intval($postId));

        echo json_encode([
            'success' => true,
            'new_votes' => (int) $post['votes'],
            'new_user_vote' => $result
        ]);
        return;
    }

    public function voteComment(string $commentId)
    {
        $this->requireLogin();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$isAjax) {
            $accountId = $_SESSION['account_id'];
            $vote = intval($_POST['vote']);

            if (!in_array($vote, [1, -1])) {
                header("Location: /posts");
                exit;
            }

            $voteModel = new Vote();
            $voteModel->voteComment(intval($commentId), intval($accountId), $vote);

            $redirect = $_POST['redirect'] ?? '/posts';
            header("Location: $redirect");
            exit;
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['account_id'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Not logged in'
            ]);
            return;
        }

        $accountId = $_SESSION['account_id'];
        $vote = isset($_POST['vote']) ? intval($_POST['vote']) : null;

        if (!in_array($vote, [1, -1])) {
            echo json_encode([
                'success' => false,
                'error' => 'Invalid vote value'
            ]);
            return;
        }

        $voteModel = new Vote();
        $result = $voteModel->voteComment(intval($commentId), intval($accountId), $vote);

        $commentModel = new Comment();
        $comment = $commentModel->getCommentById(intval($commentId));

        if (!$comment) {
            echo json_encode([
                'success' => false,
                'error' => 'Comment not found'
            ]);
            return;
        }

        echo json_encode([
            'success' => true,
            'new_votes' => (int) $comment['votes'],
            'new_user_vote' => $result
        ]);
        return;
    }

    public function voteReply(string $replyId)
    {
        $this->requireLogin();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$isAjax) {
            $accountId = $_SESSION['account_id'];
            $vote = intval($_POST['vote']);

            if (!in_array($vote, [1, -1])) {
                header("Location: /posts");
                exit;
            }

            $voteModel = new Vote();
            $voteModel->voteReply(intval($replyId), intval($accountId), $vote);

            $redirect = $_POST['redirect'] ?? '/posts';
            header("Location: $redirect");
            exit;
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['account_id'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Not logged in'
            ]);
            return;
        }

        $accountId = $_SESSION['account_id'];
        $vote = isset($_POST['vote']) ? intval($_POST['vote']) : null;

        if (!in_array($vote, [1, -1])) {
            echo json_encode([
                'success' => false,
                'error' => 'Invalid vote value'
            ]);
            return;
        }

        $voteModel = new Vote();
        $result = $voteModel->voteReply(intval($replyId), intval($accountId), $vote);

        $replyModel = new Reply();
        $reply = $replyModel->getReplyById(intval($replyId));

        if (!$reply) {
            echo json_encode([
                'success' => false,
                'error' => 'Reply not found'
            ]);
            return;
        }

        echo json_encode([
            'success' => true,
            'new_votes' => (int) $reply['votes'],
            'new_user_vote' => $result
        ]);
        return;
    }
}
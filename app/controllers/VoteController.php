<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Vote;

class VoteController extends Controller
{
    public function votePost(string $postId)
    {
        $accountId = $_SESSION['account_id'];
        $vote      = intval($_POST['vote']);

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

    public function voteComment(string $commentId)
    {
        $accountId = $_SESSION['account_id'];
        $vote      = intval($_POST['vote']);

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

    public function voteReply(string $replyId)
    {
        $accountId = $_SESSION['account_id'];
        $vote      = intval($_POST['vote']);

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
}
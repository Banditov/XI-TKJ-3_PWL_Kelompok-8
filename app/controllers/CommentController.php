<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(string $postId)
    {
        $description = $_POST['description'];
        $accountId   = $_SESSION['account_id'];

        $commentModel = new Comment();
        $commentModel->createComment($postId, $accountId, $description);

        header("Location: /posts/$postId");
        exit;
    }
}
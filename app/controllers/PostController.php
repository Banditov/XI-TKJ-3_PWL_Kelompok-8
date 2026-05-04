<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        $postModel = new Post();
        $posts = $postModel->getPosts();

        $this->view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(string $id)
    {
        $id = intval($id);

        $postModel = new Post();
        $post = $postModel->getPostById($id);

        $this->view('posts.show', [
            'post' => $post
        ]);
    }

    public function create()
    {
        $this->view('posts.create',[
        ]);
    }

    public function store()
    {
        $title       = $_POST['title'];
        $description = $_POST['description'];
        $accountId   = $_SESSION['account_id'];

        $postModel = new Post();
        $postId    = $postModel->createPost($title, $description, $accountId);

        if (!empty($_POST['tag_name'])) {
            $tagModel = new Tag();
            foreach ($_POST['tag_name'] as $index => $tagName) {
                if (empty($tagName)) continue;
                $colorTop    = $_POST['color_top'][$index]    ?? 'ffffff';
                $colorBottom = $_POST['color_bottom'][$index] ?? 'ffffff';
                $tagModel->createTag($postId, $tagName, $colorTop, $colorBottom);
            }
        }

        header('Location: /posts');
        exit;
    }
}
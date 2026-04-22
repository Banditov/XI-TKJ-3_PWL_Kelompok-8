<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

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
}
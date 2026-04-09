<?php
namespace App\Controllers;

use App\Core\Controller;

class PostController extends Controller
{
    public function index()
    {
        $this->view('posts.index');
    }

    public function show(string $id)
    {
        $this->view('posts.show');
    }
}
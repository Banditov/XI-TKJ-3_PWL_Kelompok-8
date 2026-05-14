<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Reply;

class PostController extends Controller
{
    public function index()
    {
        $postModel = new Post();
        $tagModel  = new Tag();
        $tagModel->deleteUnusedTags();
        $tags = $tagModel->getTags();

        $filters = [
            'search'     => $_GET['search']     ?? '',
            'tag'        => $_GET['tag']        ?? '',
            'votes_min'  => $_GET['votes_min']  ?? '',
            'votes_max'  => $_GET['votes_max']  ?? '',
            'views_min'  => $_GET['views_min']  ?? '',
            'views_max'  => $_GET['views_max']  ?? '',
        ];

        $posts = $postModel->getPosts($filters);
        $tags  = $tagModel->getTags();

        $_SESSION['filter_tags']    = $tags;
        $_SESSION['filter_filters'] = $filters;

        $this->view('posts.index', [
            'posts'   => $posts,
            'tags'    => $tags,
            'filters' => $filters
        ]);
    }

    public function show(string $id)
    {
        $id = intval($id);

        $postModel    = new Post();
        $commentModel = new Comment();
        $replyModel   = new Reply();

        $postModel->incrementViews($id, $_SESSION['account_id']);

        $post     = $postModel->getPostById($id);
        $comments = $commentModel->getCommentsByPostId($id);

        foreach ($comments as &$comment) {
            $comment['replies'] = $replyModel->getRepliesByCommentId($comment['id']);
        }

        $this->view('posts.show', [
            'post'     => $post,
            'comments' => $comments
        ]);
    }

    public function create()
    {
        $this->view('posts.create',[
        ]);
    }

    public function store()
    {
        $title       = $_POST['title']       ?? '';
        $description = $_POST['description'] ?? '';
        $accountId   = $_SESSION['account_id'];

        $postModel = new Post();
        $postId    = $postModel->createPost($title, $description, $accountId);

        if (!$postId) {
            header('Location: /posts/create?error=duplicate_title');
            exit;
        }

        if (!empty($_POST['tag_name'])) {
            $tagModel = new Tag();
            foreach ($_POST['tag_name'] as $index => $tagName) {
                if (empty($tagName)) continue;
                $colorTop    = $_POST['color_top'][$index]    ?? 'ffffff';
                $colorBottom = $_POST['color_bottom'][$index] ?? 'ffffff';
                $icon        = $_POST['icon'][$index]         ?? 'tag';
                $tagModel->createTag($postId, $tagName, $colorTop, $colorBottom, $icon);
            }
        }

        if (!empty($_POST['imgs'])) {
            foreach ($_POST['imgs'] as $filename) {
                if (empty($filename)) continue;
                $postModel->addImage($postId, $filename);
            }
        }

        if (!empty($_POST['link_url'])) {
            foreach ($_POST['link_url'] as $index => $url) {
                if (empty($url)) continue;
                $linkText = $_POST['link_text'][$index] ?? '';
                $postModel->addLink($postId, $url, $linkText);
            }
        }

        header('Location: /posts');
        exit;
    }
}
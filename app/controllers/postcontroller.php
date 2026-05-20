<?php
namespace app\controllers;

use app\core\controller;
use app\models\post;
use app\models\tag;
use app\models\comment;
use app\models\reply;

class postcontroller extends controller
{
    public function index()
    {
        $this->requireLogin();

        $postModel = new post();
        $tagModel = new tag();
        $tagModel->deleteUnusedTags();

        $tags = $tagModel->getUniqueTagsForFilter();

        $filters = [
            'search' => $_GET['search'] ?? '',
            'tag' => $_GET['tag'] ?? '',
            'votes_min' => $_GET['votes_min'] ?? '',
            'votes_max' => $_GET['votes_max'] ?? '',
            'views_min' => $_GET['views_min'] ?? '',
            'views_max' => $_GET['views_max'] ?? '',
        ];

        $posts = $postModel->getPosts($filters);

        shuffle($posts);

        $_SESSION['filter_tags'] = $tags;
        $_SESSION['filter_filters'] = $filters;

        $this->view('posts.index', [
            'posts' => $posts,
            'tags' => $tags,
            'filters' => $filters
        ]);
    }

    public function show(string $id)
    {
        $this->requireLogin();

        $id = intval($id);

        $postModel = new post();
        $commentModel = new comment();
        $replyModel = new reply();

        $postModel->incrementViews($id, $_SESSION['account_id']);

        $post = $postModel->getPostById($id);
        $comments = $commentModel->getCommentsByPostId($id);

        foreach ($comments as &$comment) {
            $comment['replies'] = $replyModel->getRepliesByCommentId($comment['id']);
        }

        $this->view('posts.show', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function create()
    {
        $this->requireLogin();
        $this->view('posts.create', [
        ]);
    }

    public function store()
    {
        $this->requireLogin();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $accountId = $_SESSION['account_id'];

        if (empty($title)) {
            $_SESSION['error'] = 'Post title cannot be empty';
            header("Location: /posts/create");
            exit;
        }

        if (empty($description)) {
            $_SESSION['error'] = 'Post description cannot be empty';
            header("Location: /posts/create");
            exit;
        }

        $postModel = new post();
        $postId = $postModel->createPost($title, $description, $accountId);

        if (!$postId) {
            $_SESSION['error'] = 'A post with this title already exists. Please use a different title.';
            header("Location: /posts/create");
            exit;
        }

        if (!empty($_POST['model_3d'])) {
            $postModel->add3DModel($postId, $_POST['model_3d']);
        }

        if (!empty($_POST['tag_name']) && is_array($_POST['tag_name'])) {
            $tagModel = new tag();
            foreach ($_POST['tag_name'] as $index => $tagName) {
                $tagName = trim($tagName);
                if (empty($tagName))
                    continue;

                $colorTop = $_POST['tag_color_top'][$index] ?? 'CCCCCC';
                $colorBottom = $_POST['tag_color_bottom'][$index] ?? 'CCCCCC';
                $icon = $_POST['tag_icon'][$index] ?? 'tag';

                $tagModel->createTag($postId, $tagName, $colorTop, $colorBottom, $icon);
            }
        }

        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = __DIR__ . '/../../public/assets/image/post/';

            if (!is_dir($uploadDir) || !is_readable($uploadDir)) {
                $uploadDir = __DIR__ . '/../../assets/image/post/';
            }

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = 'post_' . uniqid() . '_' . $_FILES['images']['name'][$key];
                    $destination = $uploadDir . $fileName;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $postModel->addImage($postId, $fileName);
                    }
                }
            }
        }

        if (!empty($_POST['imgs']) && is_array($_POST['imgs'])) {
            foreach ($_POST['imgs'] as $filename) {
                if (empty($filename))
                    continue;
                $postModel->addImage($postId, $filename);
            }
        }

        if (!empty($_POST['link_url']) && is_array($_POST['link_url'])) {
            foreach ($_POST['link_url'] as $index => $url) {
                $url = trim($url);
                if (empty($url))
                    continue;

                $linkText = $_POST['link_text'][$index] ?? '';
                $postModel->addLink($postId, $url, $linkText);
            }
        }

        $_SESSION['success'] = 'Post created successfully!';
        header("Location: /posts/{$postId}");
        exit;
    }

    public function edit(string $id)
    {
        $this->requireLogin();

        $postModel = new post();
        $post = $postModel->getPostById($id);

        if (!$post) {
            header("Location: /posts");
            exit;
        }

        if ($post['account_id'] != $_SESSION['account_id'] && $_SESSION['is_admin'] != 1) {
            header("Location: /posts/{$id}");
            exit;
        }

        $this->view('posts/edit', [
            'post' => $post
        ]);
    }

    public function update(string $id)
    {
        $this->requireLogin();

        $postModel = new post();
        $post = $postModel->getPostById($id);

        if (!$post) {
            header("Location: /posts");
            exit;
        }

        if ($post['account_id'] != $_SESSION['account_id'] && ($_SESSION['is_admin'] ?? 0) != 1) {
            header("Location: /posts/{$id}");
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($title)) {
            $_SESSION['error'] = 'Post title cannot be empty';
            header("Location: /posts/{$id}/edit");
            exit;
        }

        if (empty($description)) {
            $_SESSION['error'] = 'Post description cannot be empty';
            header("Location: /posts/{$id}/edit");
            exit;
        }

        $result = $postModel->updatePost(intval($id), $title, $description);

        if (!$result) {
            $_SESSION['error'] = 'Failed to update post';
            header("Location: /posts/{$id}/edit");
            exit;
        }

        $tagModel = new tag();
        $tagModel->deleteTagsByPostId(intval($id));

        if (!empty($_POST['tag_name']) && is_array($_POST['tag_name'])) {
            foreach ($_POST['tag_name'] as $index => $tagName) {
                $tagName = trim($tagName);
                if (empty($tagName))
                    continue;

                $colorTop = $_POST['tag_color_top'][$index] ?? 'CCCCCC';
                $colorBottom = $_POST['tag_color_bottom'][$index] ?? 'CCCCCC';
                $icon = $_POST['tag_icon'][$index] ?? 'tag';

                $tagModel->createTag(intval($id), $tagName, $colorTop, $colorBottom, $icon);
            }
        }

        if (!empty($_POST['existing_images'])) {
            $keepImages = $_POST['existing_images'];
        } else {
            $keepImages = [];
        }

        $currentImages = $postModel->getImagesByPostId(intval($id));
        foreach ($currentImages as $img) {
            if (!in_array($img['file_name'], $keepImages)) {
                $filePath = __DIR__ . '/../../public/assets/image/post/' . $img['file_name'];

                if (!is_dir($filePath) || !is_readable($filePath)) {
                    $filePath = __DIR__ . '/../../assets/image/post/' . $img['file_name'];
                }

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $postModel->deleteImage($img['id']);
            }
        }

        if (!empty($_POST['imgs']) && is_array($_POST['imgs'])) {
            foreach ($_POST['imgs'] as $filename) {
                if (empty($filename))
                    continue;
                $postModel->addImage(intval($id), $filename);
            }
        }

        $postModel->deleteLinksByPostId(intval($id));

        if (!empty($_POST['existing_links']) && is_array($_POST['existing_links'])) {
            foreach ($_POST['existing_links'] as $index => $url) {
                $url = trim($url);
                if (empty($url))
                    continue;

                $linkText = $_POST['existing_link_texts'][$index] ?? $url;
                $postModel->addLink(intval($id), $url, $linkText);
            }
        }

        if (!empty($_POST['link_url']) && is_array($_POST['link_url'])) {
            foreach ($_POST['link_url'] as $index => $url) {
                $url = trim($url);
                if (empty($url))
                    continue;

                $linkText = $_POST['link_text'][$index] ?? '';
                $postModel->addLink(intval($id), $url, $linkText);
            }
        }

        if (!empty($_POST['model_3d'])) {
            $modelFilename = $_POST['model_3d'];
            $postModel->add3DModel(intval($id), $modelFilename);
        }

        if (isset($_POST['remove_model']) && $_POST['remove_model'] == 1) {
            $postModel->remove3DModel(intval($id));
        }

        $_SESSION['success'] = 'Post updated successfully!';
        header("Location: /posts/{$id}");
        exit;
    }

    public function delete(string $id)
    {
        $this->requireLogin();

        $postModel = new Post();
        $post = $postModel->getPostById($id);

        if (!$post) {
            header("Location: /posts");
            exit;
        }

        if ($post['account_id'] != $_SESSION['account_id'] && ($_SESSION['is_admin'] ?? 0) != 1) {
            header("Location: /posts/{$id}");
            exit;
        }

        $postModel->deletePostCompletely(intval($id));

        $_SESSION['success'] = 'Post deleted successfully!';
        header("Location: /posts");
        exit;
    }

    public function latest()
    {
        $this->requireLogin();

        $postModel = new post();
        $tagModel = new tag();
        $tagModel->deleteUnusedTags();

        $tags = $tagModel->getUniqueTagsForFilter();

        $filters = [
            'search' => $_GET['search'] ?? '',
            'tag' => $_GET['tag'] ?? '',
            'votes_min' => $_GET['votes_min'] ?? '',
            'votes_max' => $_GET['votes_max'] ?? '',
            'views_min' => $_GET['views_min'] ?? '',
            'views_max' => $_GET['views_max'] ?? '',
        ];

        $posts = $postModel->getLatestPosts($filters);

        $_SESSION['filter_tags'] = $tags;
        $_SESSION['filter_filters'] = $filters;

        $this->view('posts.latest', [
            'posts' => $posts,
            'tags' => $tags,
            'filters' => $filters
        ]);
    }

    public function popular()
    {
        $this->requireLogin();

        $postModel = new post();
        $tagModel = new tag();
        $tagModel->deleteUnusedTags();

        $tags = $tagModel->getUniqueTagsForFilter();

        $filters = [
            'search' => $_GET['search'] ?? '',
            'tag' => $_GET['tag'] ?? '',
            'votes_min' => $_GET['votes_min'] ?? '',
            'votes_max' => $_GET['votes_max'] ?? '',
            'views_min' => $_GET['views_min'] ?? '',
            'views_max' => $_GET['views_max'] ?? '',
        ];

        $posts = $postModel->getPopularPosts($filters);

        $_SESSION['filter_tags'] = $tags;
        $_SESSION['filter_filters'] = $filters;

        $this->view('posts.popular', [
            'posts' => $posts,
            'tags' => $tags,
            'filters' => $filters
        ]);
    }

    public function myPosts()
    {
        $this->requireLogin();

        $postModel = new post();
        $tagModel = new tag();
        $tagModel->deleteUnusedTags();

        $tags = $tagModel->getUniqueTagsForFilter();

        $filters = [
            'search' => $_GET['search'] ?? '',
            'tag' => $_GET['tag'] ?? '',
            'votes_min' => $_GET['votes_min'] ?? '',
            'votes_max' => $_GET['votes_max'] ?? '',
            'views_min' => $_GET['views_min'] ?? '',
            'views_max' => $_GET['views_max'] ?? '',
        ];

        $posts = $postModel->getMyPosts($_SESSION['account_id'], $filters);

        $_SESSION['filter_tags'] = $tags;
        $_SESSION['filter_filters'] = $filters;

        $this->view('posts.mypost', [
            'posts' => $posts,
            'tags' => $tags,
            'filters' => $filters
        ]);
    }

    public function pinned()
    {
        $postModel = new post();
        $tagModel = new tag();

        $tags = $tagModel->getUniqueTagsForFilter();

        $filters = [
            'search' => $_GET['search'] ?? '',
            'tag' => $_GET['tag'] ?? '',
            'votes_min' => $_GET['votes_min'] ?? '',
            'votes_max' => $_GET['votes_max'] ?? '',
            'views_min' => $_GET['views_min'] ?? '',
            'views_max' => $_GET['views_max'] ?? '',
        ];

        $posts = $postModel->getPinnedPosts($filters);

        $_SESSION['filter_tags'] = $tags;
        $_SESSION['filter_filters'] = $filters;

        $this->view('posts.pinned', [
            'posts' => $posts,
            'tags' => $tags,
            'filters' => $filters
        ]);
    }

    public function pin(string $id)
    {
        $this->requireAdmin();

        $tagModel = new tag();
        $result = $tagModel->pinPost(intval($id));

        if ($result) {
            $_SESSION['success'] = 'Post pinned successfully!';
        } else {
            $_SESSION['error'] = 'Failed to pin post';
        }

        header("Location: /posts/{$id}");
        exit;
    }

    public function unpin(string $id)
    {
        $this->requireAdmin();

        $tagModel = new tag();
        $result = $tagModel->unpinPost(intval($id));

        if ($result) {
            $_SESSION['success'] = 'Post unpinned successfully!';
        } else {
            $_SESSION['error'] = 'Failed to unpin post';
        }

        header("Location: /posts/{$id}");
        exit;
    }
}
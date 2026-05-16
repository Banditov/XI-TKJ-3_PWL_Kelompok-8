<?php
session_start();

spl_autoload_register(function ($class) {
    $class = str_replace('App\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $file  = __DIR__ . '/../app/' . strtolower($class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . '/../app/resources/icons/icon.php';

use App\Core\Router;

$router = new Router();

$GLOBALS['tags']    = [];
$GLOBALS['filters'] = [];

// Intro
$router->add('GET', '/', 'IntroController', 'index');

// Login view
$router->add('GET', '/login', 'AuthController', 'login');

// Post views
$router->add('GET', '/posts', 'PostController', 'index');
$router->add('GET', '/posts/create', 'PostController', 'create');
$router->add('GET', '/posts/{id}', 'PostController', 'show');
$router->add('GET', '/posts/{id}/edit', 'PostController', 'edit');
$router->add('GET', '/latest', 'PostController', 'latest');
$router->add('GET', '/popular', 'PostController', 'popular');
$router->add('GET', '/mypost', 'PostController', 'myPosts');
$router->add('GET', '/pinned', 'PostController', 'pinned');

// Post creation
$router->add('POST', '/posts', 'PostController', 'store');

// Login
$router->add('POST', '/login', 'AuthController', 'authenticate');

// Logout
$router->add('GET', '/logout', 'AuthController', 'logout');

// Comment
$router->add('POST', '/posts/{id}/comments', 'CommentController', 'store');
$router->add('POST', '/posts/{id}/comments/{commentId}/replies', 'ReplyController', 'store');

// Voting
$router->add('POST', '/posts/{id}/vote', 'VoteController', 'votePost');
$router->add('POST', '/comments/{id}/vote', 'VoteController', 'voteComment');
$router->add('POST', '/replies/{id}/vote',  'VoteController', 'voteReply');

// Image upload
$router->add('POST', '/upload/image', 'UploadController', 'image');

// Image optimizer
$router->add('POST', '/admin/optimize', 'OptimizeController', 'optimizeExisting');

// Post edit
$router->add('POST', '/posts/{id}/update', 'PostController', 'update');
$router->add('POST', '/posts/{id}/delete', 'PostController', 'delete');

// Cleanup
$router->add('GET', '/admin/cleanup', 'CleanupController', 'showCleanupPage');
$router->add('POST', '/admin/cleanup/run', 'CleanupController', 'removeUnusedImages');

// Admin pin
$router->add('POST', '/posts/{id}/pin', 'PostController', 'pin');
$router->add('POST', '/posts/{id}/unpin', 'PostController', 'unpin');

// Settings
$router->add('POST', '/settings/dyslexic', 'SettingsController', 'toggleDyslexic');
$router->add('POST', '/settings/dark', 'SettingsController', 'toggleDark');

// Notification
$router->add('GET', '/notifications', 'NotificationController', 'notifications');

$router->run();
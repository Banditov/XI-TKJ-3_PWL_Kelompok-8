<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Asia/Jakarta');

// SELF-HOSTING
spl_autoload_register(function ($class) {
    $class = str_replace('app\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../app/' . strtolower($class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . '/../app/resources/icons/icon.php';

// HOSTING
// spl_autoload_register(function ($class) {
//     $class = str_replace('\\', '/', $class);
//     $file = __DIR__ . '/' . $class . '.php';
//     if (file_exists($file)) {
//         require_once $file;
//     } else {
//         die("Missing: " . $file);
//     }
// });

// require_once __DIR__ . '/app/resources/icons/icon.php';

use app\core\router;

$router = new router();

$GLOBALS['tags'] = [];
$GLOBALS['filters'] = [];


// Views
// Intro
$router->add('GET', '/', 'introcontroller', 'index');

// Login
$router->add('GET', '/login', 'authcontroller', 'login');

// Post
$router->add('GET', '/posts', 'postcontroller', 'index');
$router->add('GET', '/posts/create', 'postcontroller', 'create');
$router->add('GET', '/posts/{id}', 'postcontroller', 'show');
$router->add('GET', '/posts/{id}/edit', 'postcontroller', 'edit');
$router->add('GET', '/latest', 'postcontroller', 'latest');
$router->add('GET', '/popular', 'postcontroller', 'popular');
$router->add('GET', '/mypost', 'postcontroller', 'myPosts');
$router->add('GET', '/pinned', 'postcontroller', 'pinned');

// Notification
$router->add('GET', '/notification', 'notificationcontroller', 'index');


// Functions
// Post creation
$router->add('POST', '/posts', 'postcontroller', 'store');

// Login
$router->add('POST', '/login', 'authcontroller', 'authenticate');

// Logout
$router->add('GET', '/logout', 'authcontroller', 'logout');

// Comment
$router->add('POST', '/posts/{id}/comments', 'commentcontroller', 'store');
$router->add('POST', '/posts/{id}/comments/{commentId}/replies', 'replycontroller', 'store');
$router->add('POST', '/comments/{id}/delete', 'commentcontroller', 'delete');
$router->add('POST', '/replies/{id}/delete', 'replycontroller', 'delete');

// Voting
$router->add('POST', '/posts/{id}/vote', 'votecontroller', 'votePost');
$router->add('POST', '/comments/{id}/vote', 'votecontroller', 'voteComment');
$router->add('POST', '/replies/{id}/vote', 'votecontroller', 'voteReply');

// Image upload
$router->add('POST', '/upload/image', 'uploadcontroller', 'image');

// 3D model upload and delete
$router->add('POST', '/upload/model', 'uploadcontroller', 'model3d');
$router->add('POST', '/upload/model/delete', 'uploadcontroller', 'deleteModel');

// Post edit
$router->add('POST', '/posts/{id}/update', 'postcontroller', 'update');
$router->add('POST', '/posts/{id}/delete', 'postcontroller', 'delete');

// Settings
$router->add('POST', '/settings/dyslexic', 'settingscontroller', 'toggleDyslexic');
$router->add('POST', '/settings/dark', 'settingscontroller', 'toggleDark');

$router->add('POST', '/notification/delete', 'notificationcontroller', 'delete');
$router->add('POST', '/notification/clear-all', 'notificationcontroller', 'clearAll');


// Admin functions
// Pin
$router->add('POST', '/posts/{id}/pin', 'postcontroller', 'pin');
$router->add('POST', '/posts/{id}/unpin', 'postcontroller', 'unpin');

// Cleanup
$router->add('GET', '/admin/cleanup', 'cleanupcontroller', 'showCleanupPage');
$router->add('POST', '/admin/cleanup/images', 'cleanupcontroller', 'removeUnusedImages');
$router->add('POST', '/admin/cleanup/models', 'cleanupcontroller', 'removeUnusedModels');


$router->run();
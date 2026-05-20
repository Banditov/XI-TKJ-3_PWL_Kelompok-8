<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Tag;

class NotificationController extends Controller
{
    public function notifications()
    {
        $notifications = [];
        $is_dyslexic = $_SESSION['is_dyslexic'] ?? false;
        $user_name = $_SESSION['name'] ?? 'Guest';

        $this->view('posts/notifications', [
            'notifications' => $notifications,
            'is_dyslexic' => $is_dyslexic,
            'user_name' => $user_name
        ]);
    }
}
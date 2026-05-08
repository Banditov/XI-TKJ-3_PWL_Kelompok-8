<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Tag;

class NotificationController extends Controller
{
    public function notifications()
    {
        require_once '../app/controllers/notifications.php';
    }
}
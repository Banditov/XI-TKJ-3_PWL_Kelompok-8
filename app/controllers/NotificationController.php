<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $this->requireLogin();

        $notificationModel = new Notification();
        $notifications = $notificationModel->getNotificationsByUser($_SESSION['account_id']);

        $this->view('notification.index', [
            'notifications' => $notifications
        ]);
    }

    public function delete()
    {
        $this->requireLogin();

        $notificationId = intval($_POST['notification_id'] ?? 0);

        if ($notificationId) {
            $notificationModel = new Notification();
            $result = $notificationModel->deleteNotification($notificationId, $_SESSION['account_id']);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete notification']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid notification ID']);
        }
        exit;
    }

    public function clearAll()
    {
        $this->requireLogin();

        $notificationModel = new Notification();
        $result = $notificationModel->clearAllNotifications($_SESSION['account_id']);

        echo json_encode(['success' => $result]);
        exit;
    }
}
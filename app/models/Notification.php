<?php
namespace App\Models;

class Notification extends BaseModel
{
    protected $table = 'notification';

    public function createCommentNotification(int $postOwnerId, int $commentId)
    {
        $date = date('Y-m-d');
        $query = "INSERT INTO {$this->table} (account_id, comment_id, date) 
                  VALUES ('$postOwnerId', '$commentId', '$date')";
        return mysqli_query($this->connection, $query);
    }

    public function createReplyNotification(int $commentOwnerId, int $replyId)
    {
        $date = date('Y-m-d');
        $query = "INSERT INTO {$this->table} (account_id, reply_id, date) 
                  VALUES ('$commentOwnerId', '$replyId', '$date')";
        return mysqli_query($this->connection, $query);
    }

    public function getNotificationsByUser(int $accountId)
    {
        $query = "SELECT n.*, 
                        c.description AS comment_description,
                        c.post_id,
                        c.account_id AS comment_author_id,
                        r.description AS reply_description,
                        r.comment_id AS reply_comment_id,
                        r.account_id AS reply_author_id,
                        a.name AS source_name,
                        cl.name AS source_class,
                        p.title AS post_title,
                        CASE 
                            WHEN n.comment_id IS NOT NULL THEN 'commented on your post'
                            WHEN n.reply_id IS NOT NULL THEN 'replied to your comment'
                            ELSE 'New notification'
                        END AS message
                FROM {$this->table} n
                LEFT JOIN comments c ON c.id = n.comment_id
                LEFT JOIN replies r ON r.id = n.reply_id
                LEFT JOIN accounts a ON a.id = COALESCE(c.account_id, r.account_id)
                LEFT JOIN classes cl ON cl.id = a.class_id
                LEFT JOIN posts p ON p.id = COALESCE(c.post_id, r.post_id)
                WHERE n.account_id = '$accountId'
                ORDER BY n.date DESC";

        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function deleteNotification(int $notificationId, int $accountId)
    {
        $query = "DELETE FROM {$this->table} WHERE id = '$notificationId' AND account_id = '$accountId'";
        return mysqli_query($this->connection, $query);
    }

    public function clearAllNotifications(int $accountId)
    {
        $query = "DELETE FROM {$this->table} WHERE account_id = '$accountId'";
        return mysqli_query($this->connection, $query);
    }
}
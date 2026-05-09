<?php
namespace App\Models;

use App\Core\Database;

class Comment extends Database
{
    protected $table = 'comments';

    public function getCommentsByPostId(string $postId)
    {
        $query = "SELECT c.*, 
                        a.name AS account_name,
                        cl.name AS class_name
                FROM {$this->table} c
                LEFT JOIN accounts a ON a.id = c.account_id
                LEFT JOIN classes cl ON cl.id = a.class_id
                WHERE c.post_id = '$postId'
                ORDER BY c.date DESC";

        $result = mysqli_query($this->connection, $query);

        $comments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }

        return $comments;
    }

    public function createComment(string $postId, string $accountId, string $description)
    {
        $date        = date('Y-m-d');
        $description = mysqli_real_escape_string($this->connection, $description);

        $query = "INSERT INTO {$this->table} (account_id, post_id, description, votes, date)
                  VALUES ('$accountId', '$postId', '$description', 0, '$date')";
        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }
}
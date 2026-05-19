<?php
namespace App\Models;

class Comment extends BaseModel
{
    protected $table = 'comments';

    public function getCommentsByPostId(string $postId)
    {
        $accountId = $_SESSION['account_id'];

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
            $id = $row['id'];

            $voteResult = mysqli_query($this->connection, "SELECT vote FROM comment_votes WHERE comment_id = '$id' AND account_id = '$accountId'");
            $voteRow = mysqli_fetch_assoc($voteResult);
            $row['user_vote'] = $voteRow ? $voteRow['vote'] : 0;

            $comments[] = $row;
        }

        return $comments;
    }

    public function createComment(string $postId, string $accountId, string $description)
    {
        $date = date('Y-m-d');
        $description = mysqli_real_escape_string($this->connection, $description);

        $query = "INSERT INTO {$this->table} (account_id, post_id, description, votes, date)
                  VALUES ('$accountId', '$postId', '$description', 0, '$date')";
        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }

    public function deleteCommentById(int $commentId)
    {
        mysqli_query($this->connection, "DELETE FROM comment_votes WHERE comment_id = '$commentId'");

        $replies = mysqli_query($this->connection, "SELECT id FROM replies WHERE comment_id = '$commentId'");
        while ($reply = mysqli_fetch_assoc($replies)) {
            mysqli_query($this->connection, "DELETE FROM reply_votes WHERE reply_id = '{$reply['id']}'");
        }
        mysqli_query($this->connection, "DELETE FROM replies WHERE comment_id = '$commentId'");

        $query = "DELETE FROM {$this->table} WHERE id = '$commentId'";
        return mysqli_query($this->connection, $query);
    }

    public function getCommentById(int $commentId)
    {
        $accountId = $_SESSION['account_id'];

        $query = "SELECT c.*, 
                        a.name AS account_name,
                        cl.name AS class_name,
                        c.post_id
                FROM {$this->table} c
                LEFT JOIN accounts a ON a.id = c.account_id
                LEFT JOIN classes cl ON cl.id = a.class_id
                WHERE c.id = '$commentId'";

        $result = mysqli_query($this->connection, $query);
        $comment = mysqli_fetch_assoc($result);

        if ($comment) {
            $voteResult = mysqli_query(
                $this->connection,
                "SELECT vote FROM comment_votes WHERE comment_id = '$commentId' AND account_id = '$accountId'"
            );
            $voteRow = mysqli_fetch_assoc($voteResult);
            $comment['user_vote'] = $voteRow ? $voteRow['vote'] : 0;
        }

        return $comment;
    }
}
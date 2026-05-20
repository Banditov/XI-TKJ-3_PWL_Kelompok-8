<?php
namespace app\models;

class reply extends basemodel
{
    protected $table = 'replies';

    public function getRepliesByCommentId(string $commentId)
    {
        $accountId = $_SESSION['account_id'];

        $query = "SELECT r.*, 
                        a.name AS account_name,
                        cl.name AS class_name
                FROM {$this->table} r
                LEFT JOIN accounts a ON a.id = r.account_id
                LEFT JOIN classes cl ON cl.id = a.class_id
                WHERE r.comment_id = '$commentId'
                ORDER BY r.date ASC";

        $result = mysqli_query($this->connection, $query);

        $replies = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];

            $voteResult = mysqli_query($this->connection, "SELECT vote FROM reply_votes WHERE reply_id = '$id' AND account_id = '$accountId'");
            $voteRow = mysqli_fetch_assoc($voteResult);
            $row['user_vote'] = $voteRow ? $voteRow['vote'] : 0;

            $replies[] = $row;
        }

        return $replies;
    }

    public function createReply(string $postId, string $commentId, string $accountId, string $description)
    {
        $date = date('Y-m-d');
        $description = mysqli_real_escape_string($this->connection, $description);

        $query = "INSERT INTO {$this->table} (account_id, post_id, comment_id, description, votes, date)
                  VALUES ('$accountId', '$postId', '$commentId', '$description', 0, '$date')";
        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }

    public function deleteReplyById(int $replyId)
    {
        mysqli_query($this->connection, "DELETE FROM reply_votes WHERE reply_id = '$replyId'");

        $query = "DELETE FROM {$this->table} WHERE id = '$replyId'";
        return mysqli_query($this->connection, $query);
    }

    public function getReplyById(int $replyId)
    {
        $accountId = $_SESSION['account_id'];

        $query = "SELECT r.*, 
                        a.name AS account_name,
                        cl.name AS class_name,
                        r.post_id,
                        r.comment_id
                FROM {$this->table} r
                LEFT JOIN accounts a ON a.id = r.account_id
                LEFT JOIN classes cl ON cl.id = a.class_id
                WHERE r.id = '$replyId'";

        $result = mysqli_query($this->connection, $query);
        $reply = mysqli_fetch_assoc($result);

        if ($reply) {
            $voteResult = mysqli_query(
                $this->connection,
                "SELECT vote FROM reply_votes WHERE reply_id = '$replyId' AND account_id = '$accountId'"
            );
            $voteRow = mysqli_fetch_assoc($voteResult);
            $reply['user_vote'] = $voteRow ? $voteRow['vote'] : 0;
        }

        return $reply;
    }
}
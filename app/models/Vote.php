<?php
namespace App\Models;

use App\Core\Database;

class Vote extends Database
{
    protected $table = 'post_votes';

    public function votePost(int $postId, int $accountId, int $vote)
    {
        $existing = mysqli_fetch_assoc(mysqli_query($this->connection,
            "SELECT * FROM post_votes WHERE post_id = '$postId' AND account_id = '$accountId'"
        ));

        if (!$existing) {
            mysqli_query($this->connection, "INSERT INTO post_votes (account_id, post_id, vote) VALUES ('$accountId', '$postId', '$vote')");
            mysqli_query($this->connection, "UPDATE posts SET votes = votes + $vote WHERE id = '$postId'");
        } elseif ($existing['vote'] == $vote) {
            mysqli_query($this->connection, "DELETE FROM post_votes WHERE post_id = '$postId' AND account_id = '$accountId'");
            mysqli_query($this->connection, "UPDATE posts SET votes = votes - $vote WHERE id = '$postId'");
        } else {
            mysqli_query($this->connection, "UPDATE post_votes SET vote = '$vote' WHERE post_id = '$postId' AND account_id = '$accountId'");
            mysqli_query($this->connection, "UPDATE posts SET votes = votes + ($vote * 2) WHERE id = '$postId'");
        }
    }

    public function voteComment(int $commentId, int $accountId, int $vote)
    {
        $existing = mysqli_fetch_assoc(mysqli_query($this->connection,
            "SELECT * FROM comment_votes WHERE comment_id = '$commentId' AND account_id = '$accountId'"
        ));

        if (!$existing) {
            mysqli_query($this->connection, "INSERT INTO comment_votes (account_id, comment_id, vote) VALUES ('$accountId', '$commentId', '$vote')");
            mysqli_query($this->connection, "UPDATE comments SET votes = votes + $vote WHERE id = '$commentId'");
        } elseif ($existing['vote'] == $vote) {
            mysqli_query($this->connection, "DELETE FROM comment_votes WHERE comment_id = '$commentId' AND account_id = '$accountId'");
            mysqli_query($this->connection, "UPDATE comments SET votes = votes - $vote WHERE id = '$commentId'");
        } else {
            mysqli_query($this->connection, "UPDATE comment_votes SET vote = '$vote' WHERE comment_id = '$commentId' AND account_id = '$accountId'");
            mysqli_query($this->connection, "UPDATE comments SET votes = votes + ($vote * 2) WHERE id = '$commentId'");
        }
    }

    public function voteReply(int $replyId, int $accountId, int $vote)
    {
        $existing = mysqli_fetch_assoc(mysqli_query($this->connection,
            "SELECT * FROM reply_votes WHERE reply_id = '$replyId' AND account_id = '$accountId'"
        ));

        if (!$existing) {
            mysqli_query($this->connection, "INSERT INTO reply_votes (account_id, reply_id, vote) VALUES ('$accountId', '$replyId', '$vote')");
            mysqli_query($this->connection, "UPDATE replies SET votes = votes + $vote WHERE id = '$replyId'");
        } elseif ($existing['vote'] == $vote) {
            mysqli_query($this->connection, "DELETE FROM reply_votes WHERE reply_id = '$replyId' AND account_id = '$accountId'");
            mysqli_query($this->connection, "UPDATE replies SET votes = votes - $vote WHERE id = '$replyId'");
        } else {
            mysqli_query($this->connection, "UPDATE reply_votes SET vote = '$vote' WHERE reply_id = '$replyId' AND account_id = '$accountId'");
            mysqli_query($this->connection, "UPDATE replies SET votes = votes + ($vote * 2) WHERE id = '$replyId'");
        }
    }
}
<?php
namespace App\Models;
require_once __DIR__ . '/../core/Database.php';

use App\Core\Database;

class Post extends Database
{
    protected $table = 'posts';
    protected $table_imgs = 'post_imgs';
    protected $table_links = 'post_links';

    public function getPosts(array $filters = [])
    {
        $where = [];

        if (!empty($filters['tag'])) {
            $tag = mysqli_real_escape_string($this->connection, $filters['tag']);
            $where[] = "EXISTS (SELECT 1 FROM tags t WHERE t.post_id = p.id AND t.name = '$tag')";
        }

        if (!empty($filters['votes_min'])) {
            $min = intval($filters['votes_min']);
            $where[] = "p.votes >= $min";
        }

        if (!empty($filters['votes_max'])) {
            $max = intval($filters['votes_max']);
            $where[] = "p.votes <= $max";
        }

        if (!empty($filters['views_min'])) {
            $min = intval($filters['views_min']);
            $where[] = "p.views >= $min";
        }

        if (!empty($filters['views_max'])) {
            $max = intval($filters['views_max']);
            $where[] = "p.views <= $max";
        }

        if (!empty($filters['search'])) {
            $search  = mysqli_real_escape_string($this->connection, $filters['search']);
            $where[] = "(p.title LIKE '%$search%' OR p.description LIKE '%$search%')";
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $query = "SELECT p.*, 
                        a.name AS account_name,
                        c.name AS class_name,
                        (SELECT COUNT(*) FROM comments WHERE post_id = p.id) +
                        (SELECT COUNT(*) FROM replies WHERE post_id = p.id) AS comment_count
                FROM {$this->table} p
                LEFT JOIN accounts a ON a.id = p.account_id
                LEFT JOIN classes c ON c.id = a.class_id
                $whereClause";

        $result = mysqli_query($this->connection, $query);

        $accountId = $_SESSION['account_id'];

        $posts = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];

            $imgResult = mysqli_query($this->connection, "SELECT file_name FROM {$this->table_imgs} WHERE post_id = '$id'");
            $row['imgs'] = mysqli_fetch_all($imgResult, MYSQLI_ASSOC);

            $linkResult = mysqli_query($this->connection, "SELECT link FROM {$this->table_links} WHERE post_id = '$id'");
            $row['links'] = mysqli_fetch_all($linkResult, MYSQLI_ASSOC);

            $tagResult = mysqli_query($this->connection, "SELECT * FROM tags WHERE post_id = '$id'");
            $row['tags'] = mysqli_fetch_all($tagResult, MYSQLI_ASSOC);

            $voteResult = mysqli_query($this->connection, "SELECT vote FROM post_votes WHERE post_id = '$id' AND account_id = '$accountId'");
            $voteRow = mysqli_fetch_assoc($voteResult);
            $row['user_vote'] = $voteRow ? $voteRow['vote'] : 0;

            $posts[] = $row;
        }

        return $posts;
    }

    public function getPostById(string $id)
    {
        $query = "SELECT p.*, 
                        a.name AS account_name,
                        c.name AS class_name
                FROM {$this->table} p
                LEFT JOIN accounts a ON a.id = p.account_id
                LEFT JOIN classes c ON c.id = a.class_id
                WHERE p.id = '$id'";

        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);

        $imgResult = mysqli_query($this->connection, "SELECT file_name FROM {$this->table_imgs} WHERE post_id = '$id'");
        $row['imgs'] = mysqli_fetch_all($imgResult, MYSQLI_ASSOC);

        $linkResult = mysqli_query($this->connection, "SELECT link FROM {$this->table_links} WHERE post_id = '$id'");
        $row['links'] = mysqli_fetch_all($linkResult, MYSQLI_ASSOC);

        $tagResult = mysqli_query($this->connection, "SELECT * FROM tags WHERE post_id = '$id'");
        $row['tags'] = mysqli_fetch_all($tagResult, MYSQLI_ASSOC);

        $accountId = $_SESSION['account_id'];
        $voteResult = mysqli_query($this->connection, "SELECT vote FROM post_votes WHERE post_id = '$id' AND account_id = '$accountId'");
        $voteRow = mysqli_fetch_assoc($voteResult);
        $row['user_vote'] = $voteRow ? $voteRow['vote'] : 0;

        return $row;
    }

    public function createPost(string $title, string $description, string $accountId)
    {
        $date = date('Y-m-d');
        $title = mysqli_real_escape_string($this->connection, $title);
        $description = mysqli_real_escape_string($this->connection, $description);
        $accountId = mysqli_real_escape_string($this->connection, $accountId);

        $query = "INSERT INTO {$this->table} (title, account_id, votes, description, date) 
                  VALUES ('$title', '$accountId', 0, '$description', '$date')";
        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }

    public function incrementViews(int $postId, int $accountId)
    {
        $check = mysqli_query($this->connection,
            "SELECT id FROM post_views WHERE account_id = '$accountId' AND post_id = '$postId'"
        );

        if (mysqli_num_rows($check) === 0) {
            mysqli_query($this->connection,
                "INSERT INTO post_views (account_id, post_id) VALUES ('$accountId', '$postId')"
            );
            mysqli_query($this->connection,
                "UPDATE {$this->table} SET views = views + 1 WHERE id = '$postId'"
            );
        }
    }
}
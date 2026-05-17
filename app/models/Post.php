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
        $accountId = $_SESSION['account_id'];
        
        $query = "SELECT p.*, 
                        a.name AS account_name,
                        c.name AS class_name
                FROM {$this->table} p
                LEFT JOIN accounts a ON a.id = p.account_id
                LEFT JOIN classes c ON c.id = a.class_id
                WHERE p.id = '$id'";

        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            return null;
        }

        $imgResult = mysqli_query($this->connection, "SELECT file_name FROM {$this->table_imgs} WHERE post_id = '$id'");
        $row['imgs'] = mysqli_fetch_all($imgResult, MYSQLI_ASSOC);

        $linkResult = mysqli_query($this->connection, "SELECT link, link_text FROM {$this->table_links} WHERE post_id = '$id'");
        $row['links'] = mysqli_fetch_all($linkResult, MYSQLI_ASSOC);

        $tagResult = mysqli_query($this->connection, "SELECT * FROM tags WHERE post_id = '$id'");
        $row['tags'] = mysqli_fetch_all($tagResult, MYSQLI_ASSOC);

        $voteResult = mysqli_query($this->connection, "SELECT vote FROM post_votes WHERE post_id = '$id' AND account_id = '$accountId'");
        $voteRow = mysqli_fetch_assoc($voteResult);
        $row['user_vote'] = $voteRow ? $voteRow['vote'] : 0;

        return $row;
    }

    public function createPost(string $title, string $description, string $accountId)
    {
        $date        = date('Y-m-d');
        $title       = mysqli_real_escape_string($this->connection, $title);
        $description = mysqli_real_escape_string($this->connection, $description);
        $accountId   = mysqli_real_escape_string($this->connection, $accountId);

        $query = "INSERT INTO {$this->table} (title, account_id, votes, description, date) 
                VALUES ('$title', '$accountId', 0, '$description', '$date')";

        try {
            mysqli_query($this->connection, $query);
            return mysqli_insert_id($this->connection);
        } catch (\mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                return null;
            }
            throw $e;
        }
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

    public function addImage(string $postId, string $fileName)
    {
        $postId   = mysqli_real_escape_string($this->connection, $postId);
        $fileName = mysqli_real_escape_string($this->connection, $fileName);
        mysqli_query($this->connection, 
            "INSERT INTO {$this->table_imgs} (post_id, file_name) VALUES ('$postId', '$fileName')"
        );
    }

    public function addLink(string $postId, string $link, string $linkText = '')
    {
        $postId   = mysqli_real_escape_string($this->connection, $postId);
        $link     = mysqli_real_escape_string($this->connection, $link);
        $linkText = mysqli_real_escape_string($this->connection, $linkText ?: $link);
        mysqli_query($this->connection,
            "INSERT INTO {$this->table_links} (post_id, link, link_text) VALUES ('$postId', '$link', '$linkText')"
        );
    }

    public function updatePost(int $postId, string $title, string $description)
    {
        $title = mysqli_real_escape_string($this->connection, $title);
        $description = mysqli_real_escape_string($this->connection, $description);

        $query = "UPDATE {$this->table} SET title = '$title', description = '$description' WHERE id = '$postId'";
        return mysqli_query($this->connection, $query);
    }

    public function getImagesByPostId(int $postId)
    {
        $query = "SELECT * FROM {$this->table_imgs} WHERE post_id = '$postId'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function deleteImage(int $imageId)
    {
        $query = "DELETE FROM {$this->table_imgs} WHERE id = '$imageId'";
        return mysqli_query($this->connection, $query);
    }

    public function deleteLinksByPostId(int $postId)
    {
        $query = "DELETE FROM {$this->table_links} WHERE post_id = '$postId'";
        return mysqli_query($this->connection, $query);
    }

    public function deletePostCompletely(int $postId)
    {
        mysqli_query($this->connection, "DELETE FROM post_votes WHERE post_id = '$postId'");

        mysqli_query($this->connection, "DELETE FROM post_views WHERE post_id = '$postId'");

        mysqli_query($this->connection, "DELETE FROM tags WHERE post_id = '$postId'");

        $comments = mysqli_query($this->connection, "SELECT id FROM comments WHERE post_id = '$postId'");
        while ($comment = mysqli_fetch_assoc($comments)) {
            $commentId = $comment['id'];
            mysqli_query($this->connection, "DELETE FROM reply_votes WHERE reply_id IN (SELECT id FROM replies WHERE comment_id = '$commentId')");
            mysqli_query($this->connection, "DELETE FROM replies WHERE comment_id = '$commentId'");
            mysqli_query($this->connection, "DELETE FROM comment_votes WHERE comment_id = '$commentId'");
        }
        mysqli_query($this->connection, "DELETE FROM comments WHERE post_id = '$postId'");

        $images = mysqli_query($this->connection, "SELECT file_name FROM post_imgs WHERE post_id = '$postId'");
        while ($img = mysqli_fetch_assoc($images)) {
            $filePath = __DIR__ . '/../../public/assets/image/post/' . $img['file_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        mysqli_query($this->connection, "DELETE FROM post_imgs WHERE post_id = '$postId'");

        mysqli_query($this->connection, "DELETE FROM post_links WHERE post_id = '$postId'");

        mysqli_query($this->connection, "DELETE FROM posts WHERE id = '$postId'");

        return true;
    }

    public function getAllUsedImages()
    {
        $query = "SELECT DISTINCT file_name FROM {$this->table_imgs}";
        $result = mysqli_query($this->connection, $query);
        $images = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row['file_name'];
        }
        return $images;
    }

    public function deleteImageByFilename($filename)
    {
        $filename = mysqli_real_escape_string($this->connection, $filename);
        $query = "DELETE FROM {$this->table_imgs} WHERE file_name = '$filename'";
        return mysqli_query($this->connection, $query);
    }

    public function getLatestPosts(array $filters = [])
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
                $whereClause
                ORDER BY p.date DESC, p.id DESC";

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

    public function getPopularPosts(array $filters = [])
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
                        (SELECT COUNT(*) FROM replies WHERE post_id = p.id) AS comment_count,
                        (p.votes + p.views) AS popularity_score
                FROM {$this->table} p
                LEFT JOIN accounts a ON a.id = p.account_id
                LEFT JOIN classes c ON c.id = a.class_id
                $whereClause
                ORDER BY p.votes DESC, p.views DESC, p.date DESC";

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

    public function getMyPosts(int $accountId, array $filters = [])
    {
        $where = ["p.account_id = '$accountId'"];

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

        $whereClause = 'WHERE ' . implode(' AND ', $where);

        $query = "SELECT p.*, 
                        a.name AS account_name,
                        c.name AS class_name,
                        (SELECT COUNT(*) FROM comments WHERE post_id = p.id) +
                        (SELECT COUNT(*) FROM replies WHERE post_id = p.id) AS comment_count
                FROM {$this->table} p
                LEFT JOIN accounts a ON a.id = p.account_id
                LEFT JOIN classes c ON c.id = a.class_id
                $whereClause
                ORDER BY p.date DESC, p.id DESC";

        $result = mysqli_query($this->connection, $query);

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

    public function getPinnedPosts(array $filters = [])
    {
        $where = ["EXISTS (SELECT 1 FROM tags t WHERE t.post_id = p.id AND LOWER(t.name) = 'pinned')"];

        if (!empty($filters['tag']) && strtolower($filters['tag']) !== 'pinned') {
            $tag = mysqli_real_escape_string($this->connection, $filters['tag']);
            $where[] = "EXISTS (SELECT 1 FROM tags t2 WHERE t2.post_id = p.id AND t2.name = '$tag')";
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

        $whereClause = 'WHERE ' . implode(' AND ', $where);

        $query = "SELECT p.*, 
                        a.name AS account_name,
                        c.name AS class_name,
                        (SELECT COUNT(*) FROM comments WHERE post_id = p.id) +
                        (SELECT COUNT(*) FROM replies WHERE post_id = p.id) AS comment_count
                FROM {$this->table} p
                LEFT JOIN accounts a ON a.id = p.account_id
                LEFT JOIN classes c ON c.id = a.class_id
                $whereClause
                ORDER BY p.date DESC, p.id DESC";

        $result = mysqli_query($this->connection, $query);

        $accountId = $_SESSION['account_id'];

        $posts = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];

            $imgResult = mysqli_query($this->connection, "SELECT file_name FROM {$this->table_imgs} WHERE post_id = '$id'");
            $row['imgs'] = mysqli_fetch_all($imgResult, MYSQLI_ASSOC);

            $linkResult = mysqli_query($this->connection, "SELECT link, link_text FROM {$this->table_links} WHERE post_id = '$id'");
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

    public function get3DModel(int $postId)
    {
        $query = "SELECT model_3d FROM {$this->table} WHERE id = '$postId'";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['model_3d'] ?? null;
    }

    public function add3DModel(int $postId, string $filename)
    {
        $filename = mysqli_real_escape_string($this->connection, $filename);
        $query = "UPDATE {$this->table} SET model_3d = '$filename' WHERE id = '$postId'";
        return mysqli_query($this->connection, $query);
    }

    public function remove3DModel(int $postId)
    {
        $result = mysqli_query($this->connection, "SELECT model_3d FROM {$this->table} WHERE id = '$postId'");
        $row = mysqli_fetch_assoc($result);

        if ($row && $row['model_3d']) {
            $filePath = __DIR__ . '/../../public/assets/models/' . $row['model_3d'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $query = "UPDATE {$this->table} SET model_3d = NULL WHERE id = '$postId'";
        return mysqli_query($this->connection, $query);
    }

    public function getAllUsedModels()
    {
        $query = "SELECT model_3d FROM {$this->table} WHERE model_3d IS NOT NULL AND model_3d != ''";
        $result = mysqli_query($this->connection, $query);
        $models = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['model_3d']) {
                $models[] = $row['model_3d'];
            }
        }
        return $models;
    }
}
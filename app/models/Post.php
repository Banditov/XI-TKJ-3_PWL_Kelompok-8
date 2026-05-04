<?php
namespace App\Models;
require_once __DIR__ . '/../core/Database.php';

use App\Core\Database;

class Post extends Database
{
    protected $table = 'posts';
    protected $table_imgs = 'post_imgs';
    protected $table_links = 'post_links';

    public function getPosts()
    {
        $query = "SELECT * FROM {$this->table}";
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

            $posts[] = $row;
        }

        return $posts;
    }

    public function getPostById(string $id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = '$id'";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);

        $imgResult = mysqli_query($this->connection, "SELECT file_name FROM {$this->table_imgs} WHERE post_id = '$id'");
        $row['imgs'] = mysqli_fetch_all($imgResult, MYSQLI_ASSOC);

        $linkResult = mysqli_query($this->connection, "SELECT link FROM {$this->table_links} WHERE post_id = '$id'");
        $row['links'] = mysqli_fetch_all($linkResult, MYSQLI_ASSOC);

        $tagResult = mysqli_query($this->connection, "SELECT * FROM tags WHERE post_id = '$id'");
        $row['tags'] = mysqli_fetch_all($tagResult, MYSQLI_ASSOC);

        return $row;
    }
}
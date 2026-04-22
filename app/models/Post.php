<?php
namespace App\Models;
require_once '../app/core/Database.php';

use App\Core\Database;

class Post extends Database
{
    protected $table       = 'posts';
    protected $table_imgs  = 'post_imgs';
    protected $table_links = 'post_links';

    public function getPosts()
    {
        $query = "SELECT p.*, 
                        i.file_name AS img, 
                        l.link
                FROM $this->table p
                LEFT JOIN $this->table_imgs  i ON i.post_id = p.id
                LEFT JOIN $this->table_links l ON l.post_id = p.id";

        $result = mysqli_query($this->connection, $query);

        $posts = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }

        return $posts;
    }

    public function getPostById(string $id)
    {
        $query = "SELECT p.*, 
                        i.file_name AS img, 
                        l.link
                FROM $this->table p
                LEFT JOIN $this->table_imgs  i ON i.post_id = p.id
                LEFT JOIN $this->table_links l ON l.post_id = p.id
                WHERE p.id = '$id'";

        $result = mysqli_query($this->connection, $query);

        return mysqli_fetch_assoc($result);
    }
}
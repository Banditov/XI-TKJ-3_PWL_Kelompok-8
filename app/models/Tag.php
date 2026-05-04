<?php
namespace App\Models;
require_once __DIR__ . '/../core/Database.php';

use App\Core\Database;

class Tag extends Database
{
    protected $table = 'tags';

    public function getTags()
    {
        $query = "SELECT * FROM $this->table";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die('Query failed: ' . mysqli_error($this->connection));
        }

        $tags = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tags[] = $row;
        }

        return $tags;
    }

    public function getTagById(string $id)
    {
        $query = "SELECT * FROM $this->table WHERE id = '$id'";
        $result = mysqli_query($this->connection, $query);

        return mysqli_fetch_assoc($result);
    }

    public function createTag(string $postId, string $name, string $colorTop, string $colorBottom)
    {
        $colorTop    = ltrim($colorTop, '#');
        $colorBottom = ltrim($colorBottom, '#');

        $name        = mysqli_real_escape_string($this->connection, $name);
        $colorTop    = mysqli_real_escape_string($this->connection, $colorTop);
        $colorBottom = mysqli_real_escape_string($this->connection, $colorBottom);

        $query = "INSERT INTO {$this->table} (post_id, name, color_top, color_bottom, icon) 
                VALUES ('$postId', '$name', '$colorTop', '$colorBottom', '')";
        mysqli_query($this->connection, $query);
    }
}
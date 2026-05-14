<?php
namespace App\Models;

use App\Core\Database;

class Tag extends Database
{
    protected $table = 'tags';

    public function getTags()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getTagsByPostId(string $postId)
    {
        $query = "SELECT * FROM {$this->table} WHERE post_id = '$postId'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getTagById(int $tagId)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = '$tagId'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function getTagByName(string $tagName)
    {
        $tagName = mysqli_real_escape_string($this->connection, $tagName);
        $query = "SELECT * FROM {$this->table} WHERE name = '$tagName' LIMIT 1";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function createTag(int $postId, string $name, string $colorTop, string $colorBottom, string $icon = 'tag')
    {
        $name = mysqli_real_escape_string($this->connection, $name);
        $colorTop = mysqli_real_escape_string($this->connection, $colorTop);
        $colorBottom = mysqli_real_escape_string($this->connection, $colorBottom);
        $icon = mysqli_real_escape_string($this->connection, $icon);
        
        $query = "INSERT INTO {$this->table} (post_id, name, color_top, color_bottom, icon) 
                  VALUES ('$postId', '$name', '$colorTop', '$colorBottom', '$icon')";
        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }

    public function deleteTagsByPostId(int $postId)
    {
        $query = "DELETE FROM {$this->table} WHERE post_id = '$postId'";
        return mysqli_query($this->connection, $query);
    }

    public function deleteUnusedTags()
    {
        $query = "DELETE FROM {$this->table} WHERE post_id IS NULL";
        return mysqli_query($this->connection, $query);
    }

    public function updateTag(int $tagId, string $name, string $colorTop, string $colorBottom, string $icon)
    {
        $name = mysqli_real_escape_string($this->connection, $name);
        $colorTop = mysqli_real_escape_string($this->connection, $colorTop);
        $colorBottom = mysqli_real_escape_string($this->connection, $colorBottom);
        $icon = mysqli_real_escape_string($this->connection, $icon);

        $query = "UPDATE {$this->table} 
                  SET name = '$name', color_top = '$colorTop', color_bottom = '$colorBottom', icon = '$icon' 
                  WHERE id = '$tagId'";
        return mysqli_query($this->connection, $query);
    }

    public function deleteTag(int $tagId)
    {
        $query = "DELETE FROM {$this->table} WHERE id = '$tagId'";
        return mysqli_query($this->connection, $query);
    }
}
<?php
namespace App\Models;

use App\Core\Database;

class Tag extends BaseModel
{
    protected $table = 'tags';

    public function getTagsByPostId(string $postId)
    {
        $query = "SELECT * FROM {$this->table} WHERE post_id = '$postId'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        if (strtolower($name) === 'pinned') {
            return false;
        }

        $name = mysqli_real_escape_string($this->connection, $name);
        $colorTop = mysqli_real_escape_string($this->connection, $colorTop);
        $colorBottom = mysqli_real_escape_string($this->connection, $colorBottom);
        $icon = mysqli_real_escape_string($this->connection, $icon);

        $query = "INSERT INTO {$this->table} (post_id, name, color_top, color_bottom, icon) 
                VALUES ('$postId', '$name', '$colorTop', '$colorBottom', '$icon')";
        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }

    public function deleteUnusedTags()
    {
        $query = "DELETE FROM {$this->table} 
                WHERE post_id IS NULL 
                AND LOWER(name) != 'pinned'";
        return mysqli_query($this->connection, $query);
    }

    public function pinPost(int $postId)
    {
        $check = mysqli_query($this->connection, 
            "SELECT id FROM {$this->table} WHERE post_id = '$postId' AND LOWER(name) = 'pinned'"
        );

        if (mysqli_num_rows($check) === 0) {
            $query = "INSERT INTO {$this->table} (post_id, name, color_top, color_bottom, icon) 
                    VALUES ('$postId', 'Pinned', 'FFD700', 'FFA500', 'star')";
            return mysqli_query($this->connection, $query);
        }
        return true;
    }

    public function unpinPost(int $postId)
    {
        $query = "DELETE FROM {$this->table} WHERE post_id = '$postId' AND LOWER(name) = 'pinned'";
        return mysqli_query($this->connection, $query);
    }

    public function deleteTagsByPostId(int $postId)
    {
        $query = "DELETE FROM {$this->table} WHERE post_id = '$postId'";
        return mysqli_query($this->connection, $query);
    }

    public function getUniqueTagsForFilter()
    {
        $allTags = $this->getAll();
        $unique = [];
        foreach ($allTags as $tag) {
            if (strtolower($tag['name']) === 'pinned') {
                continue;
            }

            if (!isset($unique[$tag['name']])) {
                $unique[$tag['name']] = $tag;
            }
        }
        return array_values($unique);
    }
}
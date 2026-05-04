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
}
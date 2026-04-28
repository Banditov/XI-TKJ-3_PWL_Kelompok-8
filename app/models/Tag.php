<?php
namespace App\Models;
require_once '../app/core/Database.php';

use App\Core\Database;

class Tag extends Database
{
    protected $table       = 'tags';

    public function getTagById(string $id)
    {
        $query = "SELECT * FROM $this->table WHERE id = '$id'";

        $result = mysqli_query($this->connection, $query);

        return mysqli_fetch_assoc($result);
    }
}
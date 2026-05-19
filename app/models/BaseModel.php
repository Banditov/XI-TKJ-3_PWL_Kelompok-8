<?php
namespace App\Models;

use App\Core\Database;

class BaseModel extends Database
{
    protected $table;

    public function getAll(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE id = '$id'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result) ?: null;
    }

    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }

    public function count(): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        return (int) $row['count'];
    }

    public function exists(int $id): bool
    {
        $query = "SELECT 1 FROM {$this->table} WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($this->connection, $query);
        return mysqli_num_rows($result) > 0;
    }
}
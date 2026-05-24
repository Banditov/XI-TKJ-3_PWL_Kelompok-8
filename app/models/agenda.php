<?php
namespace app\models;

use app\core\database;

class agenda extends database
{
    protected $table = 'agenda';

    public function getCurrentAgendaByClass(int $classId)
    {
        $today = date('Y-m-d');
        $query = "SELECT a.*, acc.name as creator_name, c.name as class_name
                  FROM {$this->table} a
                  LEFT JOIN accounts acc ON acc.id = a.account_id
                  LEFT JOIN classes c ON c.id = a.class_id
                  WHERE a.class_id = '$classId' AND a.due_date >= '$today'
                  ORDER BY a.due_date ASC, a.created_at DESC";

        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getPassedAgendaByClass(int $classId)
    {
        $today = date('Y-m-d');
        $query = "SELECT a.*, acc.name as creator_name, c.name as class_name
                  FROM {$this->table} a
                  LEFT JOIN accounts acc ON acc.id = a.account_id
                  LEFT JOIN classes c ON c.id = a.class_id
                  WHERE a.class_id = '$classId' AND a.due_date < '$today'
                  ORDER BY a.due_date DESC";

        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getAllCurrentAgenda()
    {
        $today = date('Y-m-d');
        $query = "SELECT a.*, acc.name as creator_name, c.name as class_name
                  FROM {$this->table} a
                  LEFT JOIN accounts acc ON acc.id = a.account_id
                  LEFT JOIN classes c ON c.id = a.class_id
                  WHERE a.due_date >= '$today'
                  ORDER BY c.name ASC, a.due_date ASC";

        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getAllPassedAgenda()
    {
        $today = date('Y-m-d');
        $query = "SELECT a.*, acc.name as creator_name, c.name as class_name
                  FROM {$this->table} a
                  LEFT JOIN accounts acc ON acc.id = a.account_id
                  LEFT JOIN classes c ON c.id = a.class_id
                  WHERE a.due_date < '$today'
                  ORDER BY c.name ASC, a.due_date DESC";

        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getAgendaItem(int $id)
    {
        $query = "SELECT a.*, acc.name as creator_name, c.name as class_name
                  FROM {$this->table} a
                  LEFT JOIN accounts acc ON acc.id = a.account_id
                  LEFT JOIN classes c ON c.id = a.class_id
                  WHERE a.id = '$id'";

        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function createAgenda(int $classId, int $accountId, string $title, ?string $description, ?string $tags, string $dueDate)
    {
        $title = mysqli_real_escape_string($this->connection, $title);
        $description = mysqli_real_escape_string($this->connection, $description ?? '');
        $tags = mysqli_real_escape_string($this->connection, $tags ?? '');
        $dueDate = mysqli_real_escape_string($this->connection, $dueDate);
        $createdAt = date('Y-m-d H:i:s');

        $query = "INSERT INTO {$this->table} (class_id, account_id, title, description, tags, due_date, created_at) 
                  VALUES ('$classId', '$accountId', '$title', '$description', '$tags', '$dueDate', '$createdAt')";

        mysqli_query($this->connection, $query);
        return mysqli_insert_id($this->connection);
    }

    public function deleteAgenda(int $id, int $accountId)
    {
        $query = "DELETE FROM {$this->table} WHERE id = '$id' AND account_id = '$accountId'";
        return mysqli_query($this->connection, $query);
    }

    public function updateAgenda(int $id, int $classId, string $title, ?string $description, ?string $tags, string $dueDate)
    {
        $title = mysqli_real_escape_string($this->connection, $title);
        $description = mysqli_real_escape_string($this->connection, $description ?? '');
        $tags = mysqli_real_escape_string($this->connection, $tags ?? '');
        $dueDate = mysqli_real_escape_string($this->connection, $dueDate);
        $classId = intval($classId);

        $query = "UPDATE {$this->table} 
                SET class_id = '$classId', title = '$title', description = '$description', tags = '$tags', due_date = '$dueDate'
                WHERE id = '$id'";

        return mysqli_query($this->connection, $query);
    }
}
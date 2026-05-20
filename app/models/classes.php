<?php
namespace app\models;

use app\core\database;

class classes extends database
{
    protected $table = 'classes';
    
    public function getAllClasses()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
<?php
namespace App\Models;

use App\Core\Database;

class Account extends Database
{
    protected $table = 'accounts';

    public function getByEmail(string $email)
    {
        $email = mysqli_real_escape_string($this->connection, $email);
        $query = "SELECT * FROM {$this->table} WHERE email = '$email'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }
}
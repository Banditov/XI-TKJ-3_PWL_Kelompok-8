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

    public function updatePreference(int $accountId, string $field, int $value)
    {
        $field = mysqli_real_escape_string($this->connection, $field);
        $value = intval($value);
        
        $query = "UPDATE accounts SET $field = $value WHERE id = '$accountId'";
        return mysqli_query($this->connection, $query);
    }

    public function getPreferences(int $accountId)
    {
        $query = "SELECT is_dark, is_dyslexic FROM accounts WHERE id = '$accountId'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }
}
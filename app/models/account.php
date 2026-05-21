<?php
namespace app\models;

use app\core\database;

class account extends basemodel
{
    protected $table = 'accounts';

    public function __construct()
    {
        parent::__construct();
    }

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

    public function createUser(string $name, string $email, string $password, int $classId, int $isAdmin = 0)
    {
        $name = mysqli_real_escape_string($this->connection, $name);
        $email = mysqli_real_escape_string($this->connection, $email);
        $password = mysqli_real_escape_string($this->connection, $password);
        $classId = intval($classId);
        $isAdmin = intval($isAdmin);

        $query = "INSERT INTO accounts (name, email, password, class_id, is_admin, is_dark, is_dyslexic) 
                VALUES ('$name', '$email', '$password', '$classId', '$isAdmin', 0, 0)";

        if (mysqli_query($this->connection, $query)) {
            return mysqli_insert_id($this->connection);
        }

        return false;
    }

    public function updatePassword(int $userId, string $password)
    {
        $password = mysqli_real_escape_string($this->connection, $password);
        $query = "UPDATE accounts SET password = '$password' WHERE id = '$userId'";
        return mysqli_query($this->connection, $query);
    }

    public function deleteUser(int $userId)
    {
        $query = "DELETE FROM accounts WHERE id = '$userId'";
        return mysqli_query($this->connection, $query);
    }

    public function getAllUsers()
    {
        $query = "SELECT a.*, c.name as class_name 
                FROM accounts a 
                LEFT JOIN classes c ON c.id = a.class_id 
                ORDER BY a.id DESC";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function createUserAndGetId(string $name, string $email, string $password, int $classId, int $isAdmin = 0)
    {
        $name = mysqli_real_escape_string($this->connection, $name);
        $email = mysqli_real_escape_string($this->connection, $email);
        $password = mysqli_real_escape_string($this->connection, $password);
        $classId = intval($classId);
        $isAdmin = intval($isAdmin);

        $query = "INSERT INTO accounts (name, email, password, class_id, is_admin, is_dark, is_dyslexic) 
                VALUES ('$name', '$email', '$password', '$classId', '$isAdmin', 0, 0)";

        if (mysqli_query($this->connection, $query)) {
            return mysqli_insert_id($this->connection);
        }

        return false;
    }

    public function updateUser(int $userId, string $name, string $email, int $classId, int $isAdmin)
    {
        $name = mysqli_real_escape_string($this->connection, $name);
        $email = mysqli_real_escape_string($this->connection, $email);
        $classId = intval($classId);
        $isAdmin = intval($isAdmin);

        $query = "UPDATE accounts 
                SET name = '$name', email = '$email', class_id = '$classId', is_admin = '$isAdmin'
                WHERE id = '$userId'";

        return mysqli_query($this->connection, $query);
    }
}
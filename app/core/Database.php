<?php
namespace App\Core;

use mysqli;

require_once '../app/config/app.php';

class Database {
    protected $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if (!$this->connection) {
            die("Connection to database failed: " . mysqli_connect_error());
        }
    }
}
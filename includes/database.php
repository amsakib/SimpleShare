<?php

require_once("config.php");

class MySQLDatabase extends mysqli {

    private $host, $username, $password, $database;

    public function __construct($host = DB_SERVER, $username = DB_USER, $password = DB_PASS, $database = DB_NAME) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->open_connection();
    }

    public function __destruct() {
        $this->close();
    }

    private function open_connection() {
        $this->connect($this->host, $this->username, $this->password, $this->database);
        if($this->connect_error) {
            die("MySQL database connection failed. " . $this->connect_error);
        }
    }

    public function check_error() {
        if($this->error)
            echo $this->error;
    }
}

$database = new MySQLDatabase();
<?php

class User {
    public $id;
    public $fullname;
    public $username;
    public $password;
    public $email;


    function __construct($id = NULL, $fullname = NULL, $username = NULL, $password = NULL, $email = NULL){
        $this->id = $id;
        $this->fullname = $fullname;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }


    /*====== DATA ACCESS METHODS / STATIC METHODS ===========*/

    /**
     * Finds array of User objects based on the given SQL
     * @param string $sql
     * @return array
     */
    public static function find_by_sql($sql = "") {
        global $database;
        $result = $database->query($sql);
        $database->check_error();
        $object_array = array();
        while($row = $result->fetch_assoc()) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }

    /**
     * Find all users from database and
     * returns an array of users
     * @return array
     */
    public static function find_all() {
        $sql = "SELECT * FROM users";
        return self::find_by_sql($sql);
    }

    /**
     * Finds an user by id from database. Return user object if found
     * Returns false if no user is found with id $id
     * @param int $id
     * @return bool|mixed
     */
    public static function find_by_id($id = 0) {
        $sql = "SELECT * FROM users WHERE id = {$id} LIMIT 1 ";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * Authenticate a user based on Username/Password
     * Returns User object if found, otherwise return false
     * @param $username
     * @param $password
     * @return bool
     */
    public static function authenticate($username, $password) {
        $password = sha1($password);
        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    public static function create_user($user) {
        global $database;

        $sql = "INSERT INTO users (fullname, username, password, email) VALUES ( '{$user->fullname}', '{$user->username}',";
        $sql .= "'{$user->password}', '{$user->email}' )";

        $database->query($sql);
        $database->check_error();

    }


    /**
     * Instantiate an User object based on SQL Record [ Row ]
     * @param $record
     * @return User
     */
    private static function instantiate($record) {

        $object = new self($record["id"], $record["fullname"], $record["username"],
            $record["password"], $record["email"] );

        return $object;
    }
}
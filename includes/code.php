<?php

class Code {

    public $id;
    public $user_id;
    public $title;
    public $name;
    public $code;
    public $lang;
    public $privacy;

    function __construct($id = 0, $user_id = 0, $title = "", $name = "",
                         $code = "", $lang = "", $privacy = false)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->name = $name;
        $this->code = $code;
        $this->lang = $lang;
        $this->privacy = $privacy;
    }

    /* ========= DATA ACCESS METHODS ========== */

    /**
     * @param string $sql
     * @return array
     */
    public static function find_by_sql($sql = "") {
        global $database;
        // execute query
        $result = $database->query($sql);
        // check if query executed successfully
        $database->check_error();
        // an empty array of codes in the database
        $codes = array();
        // fetch each row from the result
        while($row = $result->fetch_assoc()) {
            // add to $codes array as individual code object
            $codes[] = self::instantiate($row);
        }
        return $codes;
    }

    /**
     * Get a single Code object from database by id.
     * Returns false if no such code exists with given id.
     * @param int $id
     * @return bool|mixed
     */
    public static function find_by_id($id = 0) {
        $sql = "SELECT * FROM codes WHERE ID = {$id} LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * Get all codes from database as array of Code
     * @return array
     */
    public static function find_all() {
        $sql = "SELECT * FROM codes";
        return self::find_by_sql($sql);
    }

    /**
     * Instantiate a Code object based on SQL Record [ ROW ]
     * @param $record
     * @return Code
     */
    private static function  instantiate($record) {
        $object = new self($record['id'], $record['user_id'], $record['title'], $record['name'], $record['code'],
            $record['lang'], $record['privacy']);
        return $object;
    }

}

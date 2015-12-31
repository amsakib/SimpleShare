<?php

class Code {

    public $id;
    public $user_id;
    public $title;
    public $code;
    public $lang;
    public $privacy; // 0 = Private , 1 = Public

    function __construct($id = 0, $user_id = 0, $title = "", $code = "", $lang = "", $privacy = 1)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
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
     * Get all codes from database as array of Code
     * @return array
     */
    public static function find_by_user_id($user_id) {
        $sql =  "SELECT * FROM codes WHERE user_id = " . $user_id . " ORDER BY id DESC";
        return self::find_by_sql($sql);
    }

    /**
     * Get all public codes from database as array of Code
     * @return array
     */
    public static function find_all_public() {
        $sql = "SELECT * FROM codes WHERE privacy = 1 ORDER BY id DESC";
        return self::find_by_sql($sql);
    }

    /**
     * Instantiate a Code object based on SQL Record [ ROW ]
     * @param $record
     * @return Code
     */
    private static function  instantiate($record) {

        $object = new self();

        $object->id = $record['id'];
        $object->user_id =  $record['user_id'];
        $object->title = $record['title'];
        $object->code = $record['code'];
        $object->lang = $record['lang'];
        $object->privacy = $record['privacy'];

        return $object;
    }

    /*======================= DATA ACCESS | Non-Static =================*/

    /**
     * Update if the Code is created, else Create this Code.
     * Returns true if success else return false.
     * @return bool
     */
    public function save() {
        if($this->id == 0 || !isset($this->id) || $this->id == NULL) {
            return $this->create();
        }
        else {
            return $this->update();
        }
    }

    /**
     * Create Code in Database.
     * Returns true if succeeded else false
     * @return bool
     */
    private function create() {
        global $database;
        $sql = "INSERT INTO codes (user_id, title, code, lang, privacy) VALUES ( ?, ?, ?, ?, ?)";

        $stmt = $database->prepare($sql);
        $stmt->bind_param("isssi", $this->user_id, $this->title, $this->code, $this->lang, $this->privacy);
        $stmt->execute();

        if($stmt->affected_rows == 1) {
            $this->id = $stmt->insert_id;
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Update this Code in the database.
     * Returns true if succeeded else false
     * @return bool
     */
    private function update() {
        global $database;

        $sql = "UPDATE users SET user_id = ?, title = ?, code = ?, lang = ?, privacy = ? WHERE id = ?";

        $stmt = $database->prepare($sql);
        $stmt->bind_param("isssii", $this->user_id, $this->title, $this->code, $this->lang, $this->privacy, $this->id);
        $stmt->execute();

        if($stmt->affected_rows == 1) {
            return true;
        }
        else {
            return false;
        }
    }

}
<?php

/**
 * Class Session
 * This class handles session information i.e. Login/Logout user
 */
class Session {

    private $logged_in = false;
    private $secret = "life sucks!";

    public $user_id;

    function __construct() {
        // start session
        session_start();
        // check current login status
        $this->check_login();
    }

    /**
     * returns true if user is logged in otherwise false
     * @return bool
     */
    public function is_logged_in() {
        return $this->logged_in;
    }

    /**
     * Login user
     * @param $user
     */
    public function login($user) {
        if($user) {
            $this->user_id = $user->id;
            // make hashed code
            $hashed = md5($user->id . $this->secret);
            $_SESSION['login'] = $user->id . ',' . $hashed;
        }
    }


    /**
     * Logout currently logged in user and set a session message to display
     * @param string $message
     */
    public function logout($message = '') {
        if($this->is_logged_in()){
            unset($this->user_id);
            unset($_SESSION['login']);
            $this->logged_in = false;
            $this->set_message($message);
        }
    }

    /**
     * If there is a session value exist and is a valid session value,
     * mark that an user is logged in.
     */
    private function check_login() {
        if(isset($_SESSION['login'])) {
            // extract values from session information
            list($uid, $cached_hash) = explode(',', $_SESSION['login']);
            $hashed = md5($uid . $this->secret);
            // check if the user tempered with user_id
            if($hashed == $cached_hash) {
                // store user id and mark logged in
                $this->user_id = $uid;
                $this->logged_in = true;
            }
            else { // doesn't match with originally hashed  so definitely TEMPERED!!
                unset($this->user_id);
                $this->logged_in = false;
            }
        }
        else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    public function set_message($message) {
        $_SESSION['message'] = $message;
    }

    public function remove_message() {
        if(isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
    }

    public function get_message() {
        if(isset($_SESSION['message'])) {
            return $_SESSION['message'];
        }
    }

    public function  has_message() {
        return isset($_SESSION['message']);
    }
}

// creating global session variable
// will be included this in every page
$session = new Session();
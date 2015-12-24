<?php
require_once('includes/session.php');
require_once('includes/functions.php');
if(logged_in()){
    $_SESSION = array();
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    session_start();
    $_SESSION['message'] = 'You are successfully logged out!';
}
redirect_to('signin.php');

?>
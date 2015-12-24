<?php
    session_start();

    function logged_in() {
        return isset($_SESSION['user_id']);
    }

    function confirm_logged_in() {
        if(!logged_in()) {
            $_SESSION['message'] = 'You must be logged in to view this page!';
            redirect_to('login.php');
        }
    }
<?php
require_once('includes/session.php');
require_once('includes/functions.php');
$session->logout('You are successfully logged out!');
redirect_to('signin.php');
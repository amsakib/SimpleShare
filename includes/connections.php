<?php
require('constants.php');

// Connect to database
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
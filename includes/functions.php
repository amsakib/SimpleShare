<?php
// this file stores all functions

function mysql_prep($value, $con) {
    // ASSUMED PHP VERSION 5.5
    $value = mysqli_real_escape_string($con, $value);
    return $value;
}

function redirect_to ($location = NULL) {
    if($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function confirm_query($result_set){
    if(!$result_set) {
        die("Database connection failed: " . mysqli_error($connection));
    }
}
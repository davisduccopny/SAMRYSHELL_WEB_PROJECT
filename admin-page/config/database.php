<?php

$server = "dyud5fa2qycz1o3v.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$user = "ae0xbgdqcgxqyywc";
$password = "qfudvr6re6cklso0";
$db = "r5kbcbfwrw4kmr3z";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Thiết lập charset là UTF-8
mysqli_set_charset($conn, "utf8");

// define('_WEB_HOST', 'http://'.$_SERVER['HTTP_HOST'].'/');

?>
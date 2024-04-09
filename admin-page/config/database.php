<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "samryshell";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Thiết lập charset là UTF-8
mysqli_set_charset($conn, "utf8");

// define('_WEB_HOST', 'http://'.$_SERVER['HTTP_HOST'].'/');

?>
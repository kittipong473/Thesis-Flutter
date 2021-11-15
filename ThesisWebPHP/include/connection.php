<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icars";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// UTF-8
mysqli_set_charset($conn,"UTF8");
mysqli_query($conn, 'SET CHARACTER SET utf8');
?>
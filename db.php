<?php
$servername = "127.0.0.1";
$username = "root";
$password = "ab12345678!";
$dbname = "comp344";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

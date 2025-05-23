<?php
$host = 'localhost';
$dbname = 'finalproject126';
$username = 'root';
$password = '';

// Define the connection as $mysqli instead of $conn
$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

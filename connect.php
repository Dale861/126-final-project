<?php
$host = 'localhost';
$dbname = 'finalproject126';
$username = 'root';
$password = '';

// Define the connection as $mysqli
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    error_log("Connection failed: " . $mysqli->connect_error); // Log the error
    die("There was an issue with the connection. Please try again later.");
}

// Set character set to utf8mb4 to handle special characters
$mysqli->set_charset("utf8mb4");
?>

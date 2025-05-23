<?php
<<<<<<< HEAD
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
=======

$host="localhost";
$user="root";
$pass="";
$db="login";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}
?>
>>>>>>> 1b5d3db8b2f02c9d1369e7ce9a2300bb84e1c402

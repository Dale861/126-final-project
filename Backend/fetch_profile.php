<?php
session_start();
include 'connect.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['customerID'])) {
    header("Location: index.php");
    exit();
}

$customerID = $_SESSION['customerID'];

// Fetch customer information
$query = "SELECT fname, lname, email, password FROM customers WHERE customerID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
} else {
    // Redirect if customer not found
    header("Location: index.php");
    exit();
}
?>
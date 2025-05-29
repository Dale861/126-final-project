<?php
session_start();  // Start the session
include("connect.php");  // Include the database connection file

if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];  // Get customerID from session
} else {
    // Redirect to login page if the user is not logged in
    header("Location: homepage.php");
    exit();
}
// Check if there is an orderID in the session
if (isset($_SESSION['show_loading']) && $_SESSION['show_loading'] === true) {
    // If the show_loading flag is set, we show the loading screen
    $showLoading = true;
    
    // Fetch the orderID from the session if it exists
    if (isset($_SESSION['last_order'])) {
        $orderID = $_SESSION['last_order']['orderID'];
    } else {
        $orderID = "N/A"; // Default value if orderID is not available
    }
    
    // Optionally, clear the loading session flag if you want it to be shown only once
    unset($_SESSION['show_loading']);
} else {
    // If the flag is not set, do not show the loading screen
    $showLoading = false;
    $orderID = "N/A"; // Default value if there's no orderID
}

// Handle the form submission and update the address in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];  // Get the address from the form

    // Check if the address is empty
    if (empty($address)) {
        // If the address is empty, set a default address or show an error
        echo "Error: Address cannot be empty.";
        exit();  // Stop the script execution
    }

    // Update the address for the customer in the database
    $stmt = $mysqli->prepare("UPDATE customers SET address = ? WHERE customerID = ?");
    $stmt->bind_param("si", $address, $customerID);
    $stmt->execute();

    // Optionally, redirect to another page or display a success message
    echo "Address updated successfully!";
    exit();  // End script execution after the update
}
?>
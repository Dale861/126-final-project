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

// Handle form submissions
$message = '';
$messageType = '';

// Handle personal info update
if (isset($_POST['save_personal_info'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $mobileNumber = trim($_POST['mobile_number']);
    
    // Validation
    if (empty($firstName) || empty($lastName) || empty($mobileNumber)) {
        $message = 'Please fill in all fields';
        $messageType = 'error';
    } else {
        // Update personal information
        $updateQuery = "UPDATE customers SET fname = ?, lname = ?, phone = ? WHERE customerID = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param("sssi", $firstName, $lastName, $mobileNumber, $customerID);
        
        if ($updateStmt->execute()) {
            $message = 'Personal information updated successfully!';
            $messageType = 'success';
            // Update the customer array with new values
            $customer['fname'] = $firstName;
            $customer['lname'] = $lastName;
            $customer['phone'] = $mobileNumber;
        } else {
            $message = 'Error updating personal information';
            $messageType = 'error';
        }
        $updateStmt->close();
    }
}

// Handle email update
if (isset($_POST['save_email'])) {
    $email = trim($_POST['email']);
    
    // Validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address';
        $messageType = 'error';
    } else {
        // Check if email already exists for another user
        $checkQuery = "SELECT customerID FROM customers WHERE email = ? AND customerID != ?";
        $checkStmt = $mysqli->prepare($checkQuery);
        $checkStmt->bind_param("si", $email, $customerID);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            $message = 'Email already exists for another account';
            $messageType = 'error';
        } else {
            // Update email
            $updateQuery = "UPDATE customers SET email = ? WHERE customerID = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param("si", $email, $customerID);
            
            if ($updateStmt->execute()) {
                $message = 'Email updated successfully!';
                $messageType = 'success';
                // Update the customer array with new email
                $customer['email'] = $email;
                // Update session email if it exists
                $_SESSION['email'] = $email;
            } else {
                $message = 'Error updating email';
                $messageType = 'error';
            }
            $updateStmt->close();
        }
        $checkStmt->close();
    }
}

// Handle password update
if (isset($_POST['save_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validation
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $message = 'Please fill in all password fields';
        $messageType = 'error';
    } elseif ($newPassword !== $confirmPassword) {
        $message = 'New passwords do not match';
        $messageType = 'error';
    } elseif (strlen($newPassword) < 6) {
        $message = 'Password must be at least 6 characters long';
        $messageType = 'error';
    } else {
        // Verify current password
        if (password_verify($currentPassword, $customer['password'])) {
            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update password
            $updateQuery = "UPDATE customers SET password = ? WHERE customerID = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param("si", $hashedPassword, $customerID);
            
            if ($updateStmt->execute()) {
                $message = 'Password updated successfully!';
                $messageType = 'success';
                $customer['password'] = $hashedPassword;
            } else {
                $message = 'Error updating password';
                $messageType = 'error';
            }
            $updateStmt->close();
        } else {
            $message = 'Current password is incorrect';
            $messageType = 'error';
        }
    }
}

$stmt->close();
?>
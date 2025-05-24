<?php 
include 'connect.php';

if (isset($_POST['signUp'])) {
    $fname = $_POST['fname'];  // First name
    $lname = $_POST['lname'];  // Last name
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Consider using password_hash for better security

    // Check if the email already exists
    $checkEmail = "SELECT * FROM customers WHERE email='$email'";
    $result = $mysqli->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO customers(fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')";
        if ($mysqli->query($insertQuery) === TRUE) {
            // After successful registration, get the customerID and store it in the session
            $customerID = $mysqli->insert_id; // Get the last inserted customerID
            session_start();
            $_SESSION['customerID'] = $customerID;  // Store customerID in session
            $_SESSION['email'] = $email;  // You can also store email in session if needed

            header("Location: homepage.php");
            exit();
        } else {
            echo "Error: " . $mysqli->error;
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM customers WHERE email='$email' AND password='$password'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        session_start();  // Start session to store user info
        $row = $result->fetch_assoc();

        // Store customerID and email in the session after successful login
        $_SESSION['customerID'] = $row['customerID'];  // Store the customerID from the database
        $_SESSION['email'] = $row['email'];  // Store the email

        header("Location: homepage.php");  // Redirect to homepage after login
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>

<?php 
include 'connect.php';

if (isset($_POST['signUp'])) {
    $name = $_POST['Name'];  // case-sensitive
    $email = $_POST['email'];
    $password = md5($_POST['password']); // consider password_hash for better security

    $checkEmail = "SELECT * FROM customers WHERE email='$email'";
    $result = $mysqli->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO customers(name, email, password) VALUES ('$name', '$email', '$password')";
        if ($mysqli->query($insertQuery) === TRUE) {
            header("Location: index.php");
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
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: homepage.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>

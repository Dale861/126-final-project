<?php
session_start(); // Start the session to access session variables

// Assuming you have session variables for order info (this can be adjusted based on your needs)
$orderID = isset($_SESSION['orderID']) ? $_SESSION['orderID'] : 'N/A'; // Default to 'N/A' if no orderID
$restaurantName = isset($_SESSION['restaurantName']) ? $_SESSION['restaurantName'] : 'Unknown'; // Default restaurant
$estimatedDeliveryTime = isset($_SESSION['estimatedDeliveryTime']) ? $_SESSION['estimatedDeliveryTime'] : '36 Mins'; // Default time

// You can also fetch the order details from your database if you have order data stored
// Example: Fetching data from the database based on order ID
// $mysqli = new mysqli('localhost', 'username', 'password', 'database');
// $orderQuery = "SELECT * FROM orders WHERE orderID = '$orderID'";
// $result = $mysqli->query($orderQuery);
// if ($result->num_rows > 0) {
//     $orderDetails = $result->fetch_assoc();
//     $restaurantName = $orderDetails['restaurant_name'];
//     $estimatedDeliveryTime = $orderDetails['delivery_time'];
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Tracking</title>

  <!-- Lordicon Script -->
  <script src="https://cdn.lordicon.com/lordicon.js"></script>

  <!-- External CSS -->
  <link rel="stylesheet" href="trackorder.css" />
</head>
<body>
  <header>
    <div><strong>Miagao Pabakal</strong></div>
    <nav>
      <ul>
        <li><a href="homepage.php">Home</a></li>
        <li><a href="#">Restaurant</a></li>
        <li><a href="CheckoutPage.php">Cart</a></li>
        <li><a href="#">Account</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Your Order</h1>
    <div class="delivery-time">Estimated Delivery<br><strong><?php echo $estimatedDeliveryTime; ?></strong></div>
    <div class="clock-icon">
      <lord-icon
        src="https://cdn.lordicon.com/warimioc.json"
        trigger="loop"
        state="loop-oscillate"
        style="width:250px;height:250px">
      </lord-icon>
    </div>
    <div class="progress-section">
      <div class="progress-bar">
        <div class="progress-bar-fill" id="progress-bar"></div>
      </div>
      <div class="loading-text" id="loading-text">LOADING... 0%</div>
    </div>
    <div class="order-details">
      <p>Your Order From: <strong><?php echo $restaurantName; ?></strong></p>
      <p>Order Number: <strong><?php echo $orderID; ?></strong></p>
    </div>
  </main>

  <!-- External JS -->
  <script src="delivery.js"></script>
</body>
</html>

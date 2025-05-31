<?php
session_start();  // Start the session
include 'connect.php';

// Check if the customer is logged in
if (!isset($_SESSION['customerID'])) {
    header("Location: homepage.php"); // Redirect to login page
    exit();
}

$customerID = $_SESSION['customerID']; // Get customerID from session

// Get the shop ID from the session (if set)
$shopID = isset($_SESSION['shopID']) ? $_SESSION['shopID'] : 1; // Default to 1 if not set

// Fetch cart items from the database
$cartQuery = "SELECT ci.cartItemID, p.productID, p.itemName AS name, p.price, ci.quantity, p.image_url 
              FROM CartItems ci 
              JOIN Products p ON ci.productID = p.productID 
              WHERE ci.customerID = $customerID";
$result = $mysqli->query($cartQuery);

$products = [];
$subtotal = 0;
$shippingFee = 40.00;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
        $subtotal += $row['price'] * $row['quantity'];
    }
} else {
    // If there are no products in the cart, redirect to the shop page with a message
    $_SESSION['message'] = "Your cart is empty. Please add items to your cart!";
    header("Location: restaurant.php");
    exit();
}

$totalAmount = $subtotal + $shippingFee;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($products)) {
    $orderDate = date('Y-m-d H:i:s');

    // Insert into Orders table
    $stmt = $mysqli->prepare("INSERT INTO Orders (customerID, orderDate, totalAmount) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $customerID, $orderDate, $totalAmount);
    $stmt->execute();
    $orderID = $stmt->insert_id;  // Get the auto-incremented orderID

    // Insert into OrderItems table
    foreach ($products as $product) {
        $stmt = $mysqli->prepare("INSERT INTO OrderItems (orderID, productID, quantity, priceAtOrder) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderID, $product['productID'], $product['quantity'], $product['price']);
        $stmt->execute();
    }

    // Clear the cart
    $mysqli->query("DELETE FROM CartItems WHERE customerID = $customerID");

    // Store order information in session
  $_SESSION['last_order'] = [
      'orderID' => $orderID,  // Store orderID in session for future use
      'totalAmount' => $totalAmount,
      'orderDate' => $orderDate
  ];
    
    // Set flag for loading screen
    $_SESSION['show_loading'] = true;
    
    // Redirect to homepage with loading screen
    header("Location: homepage.php");
    exit();
}
// Fetch the customer's address from the database
$addressQuery = "SELECT address FROM Customers WHERE customerID = $customerID";
$addressResult = $mysqli->query($addressQuery);

$customerAddress = "";
$latitude = 10.6433;  // Default latitude if no address is found
$longitude = 122.2355;  // Default longitude if no address is found

if ($addressResult && $addressResult->num_rows > 0) {
    $row = $addressResult->fetch_assoc();
    $customerAddress = $row['address'];

    // Geocode the address using cURL with proper headers
    $geocodeUrl = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($customerAddress);

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $geocodeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MyApp/1.0 (http://yourwebsite.com)'); // Add a user-agent header

    // Execute the cURL session and get the response
    $geocodeResponse = curl_exec($ch);

    // Check for errors in the cURL request
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        exit;
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the JSON response
    $geocodeData = json_decode($geocodeResponse, true);

    // If geocoding data is found, update latitude and longitude
    if (!empty($geocodeData)) {
        $latitude = $geocodeData[0]['lat'];
        $longitude = $geocodeData[0]['lon'];
    }
}

?>
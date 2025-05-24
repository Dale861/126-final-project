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
    header("Location: foodshoppage.php?shop=$shopID");
    exit();
}

$totalAmount = $subtotal + $shippingFee;

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

// Order placement logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($products)) {
    $orderDate = date('Y-m-d H:i:s');

    // Insert into Orders table
    $stmt = $mysqli->prepare("INSERT INTO Orders (customerID, orderDate, totalAmount) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $customerID, $orderDate, $totalAmount);
    $stmt->execute();
    $orderID = $stmt->insert_id;

    // Insert into OrderItems table
    foreach ($products as $product) {
        $stmt = $mysqli->prepare("INSERT INTO OrderItems (orderID, productID, quantity, priceAtOrder) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderID, $product['productID'], $product['quantity'], $product['price']);
        $stmt->execute();
    }

    // Clear the cart
    $mysqli->query("DELETE FROM CartItems WHERE customerID = $customerID");

    // Redirect to the tracking order page after placing the order
    header("Location: trackingorder.php?orderID=$orderID");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background: #f7f7f7;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .cart-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 40px;
    }

    .cart-left {
      flex: 1;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .cart-right {
      flex: 1;
    }

    .cart-item {
      background: #fff;
      border: 1px solid #ddd;
      margin-bottom: 20px;
      padding: 20px;
      display: flex;
      align-items: center;
      border-radius: 8px;
    }

    .cart-item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      margin-right: 20px;
      border-radius: 8px;
    }

    .cart-item-details {
      flex: 1;
    }

    .cart-item-details h2 {
      margin: 0 0 10px 0;
    }

    .summary p {
      margin: 5px 0;
    }

    .checkout-btn {
      margin-top: 20px;
      padding: 10px 20px;
      background: #000;
      color: #fff;
      font-size: 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .checkout-btn:hover {
      background: #333;
    }

    #map {
      width: 100%;
      height: 500px;
      border-radius: 10px;
    }
  </style>
</head>
<body>
      <header>
        <nav id="logo"> 
            <img src="Img/deliveryIcon.png" alt="Logo">
        </nav>
        <nav class="nav">
            <ul id="nav">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="restaurant.php">Restaurants</a></li>
                <li><a href="CheckoutPage.php">Cart</a></li> <!-- Correct link to cart page -->
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
  <div class="container">
    <div style="margin-bottom: 20px;">
      <a href="foodshoppage.php?shop=<?php echo $shopID; ?>" style="text-decoration: none; color: black; display: inline-flex; align-items: center;">
        <span style="font-size: 24px; margin-right: 8px;">&#8592;</span> <!-- Left arrow -->
        <span style="font-size: 18px;">Back to Shop</span>
      </a>
    </div>

    <h1>Checkout</h1>

    <div class="cart-wrapper">
      <div class="cart-left">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <div class="cart-item">
              <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
              <div class="cart-item-details">
                <h2><?php echo $product['name']; ?></h2>
                <p>Price: P<?php echo number_format($product['price'], 2); ?></p>
                <p>Quantity: <?php echo $product['quantity']; ?></p>
                <p>Total: P<?php echo number_format($product['price'] * $product['quantity'], 2); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Your cart is empty. Add some items to start shopping!</p>
        <?php endif; ?>

        <div class="summary">
          <p><strong>Subtotal:</strong> P<?php echo number_format($subtotal, 2); ?></p>
          <p><strong>Shipping Fee:</strong> P<?php echo number_format($shippingFee, 2); ?></p>
          <p><strong>Total Amount:</strong> P<?php echo number_format($totalAmount, 2); ?></p>
        </div>

        <form method="POST">
          <button type="submit" class="checkout-btn">Place Order</button>
        </form>
      </div>

      <div class="cart-right">
        <h2>Choose Delivery Location</h2>
        <div id="map"></div>
        <p id="address-display" style="margin-top: 10px; font-weight: bold;">Click on the map to select your delivery address.</p>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    let map;  // Declare map globally
    let marker;  // Declare marker globally

    function initMap(mapElementId, defaultLat = 10.6433, defaultLng = 122.2355, zoom = 13) {
        // Initialize the map if not already initialized
        if (!map) {
            map = L.map(mapElementId).setView([defaultLat, defaultLng], zoom);  // Set the default center

            // Add the tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
        }

        // If the marker doesn't exist, create it
        if (!marker) {
            marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
        }

        // Handle map click event to move the marker
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;

            // Move marker to clicked location
            marker.setLatLng([lat, lng]);

            // Fetch the address using reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    console.log("Geocoding Response:", data); // Log the response to check if the API returns the expected result
                    const address = data.display_name || "Address not found";
                    
                    // Directly display the address in the #address-display paragraph
                    document.getElementById('address-display').textContent = address;
                })
                .catch((error) => {
                    console.error("Error fetching address:", error);
                    document.getElementById('address-display').textContent = "Error fetching address.";
                });
        });

        // Set the map to the customer's address if available
        map.setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], zoom); // Use the customer's latitude and longitude
        marker.setLatLng([<?php echo $latitude; ?>, <?php echo $longitude; ?>]);  // Move the marker to the customer's address
        document.getElementById('address-display').textContent = "<?php echo $customerAddress; ?>";  // Display the address
    }

    // Initialize the map only if the element exists
    document.addEventListener('DOMContentLoaded', function () {
        const mapElement = document.getElementById('map');
        if (mapElement) {
            initMap('map');  // Initialize the map with the element ID 'map'
        }
    });
  </script>
</body>
</html>

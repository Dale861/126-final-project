<?php
include 'connect.php';

// Replace this with actual session-based logic
$customerID = 1;

// Fetch cart items from the database
$cartQuery = "SELECT ci.cartItemID, p.productID, p.itemName AS name, p.price, ci.quantity, p.image_url 
              FROM CartItems ci 
              JOIN Products p ON ci.productID = p.productID 
              WHERE ci.customerID = $customerID";
$result = $mysqli->query($cartQuery);

$products = [];
$subtotal = 0;
$shippingFee = 5.00;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
        $subtotal += $row['price'] * $row['quantity'];
    }
}

$totalAmount = $subtotal + $shippingFee;

// Order placement logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($products)) {
    $orderDate = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO Orders (customerID, orderDate, totalAmount) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $customerID, $orderDate, $totalAmount);
    $stmt->execute();
    $orderID = $stmt->insert_id;

    foreach ($products as $product) {
        $stmt = $mysqli->prepare("INSERT INTO OrderItems (orderID, productID, quantity, priceAtOrder) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderID, $product['productID'], $product['quantity'], $product['price']);
        $stmt->execute();
    }

    // Clear the cart
    $mysqli->query("DELETE FROM CartItems WHERE customerID = $customerID");

    header("Location: trackingorder.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

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

    .summary {
      margin-top: 40px;
      font-size: 18px;
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
  </style>
</head>
<body>
  <div style="margin-bottom: 20px;">
  <a href="foodshoppage.php" style="text-decoration: none; color: black; display: inline-flex; align-items: center;">
    <span style="font-size: 24px; margin-right: 8px;">&#8592;</span> <!-- Left arrow -->
    <span style="font-size: 18px;">Back to Shop</span>
  </a>
</div>

  <h1>Checkout</h1>

  <?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
      <div class="cart-item">
        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
        <div class="cart-item-details">
          <h2><?php echo $product['name']; ?></h2>
          <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
          <p>Quantity: <?php echo $product['quantity']; ?></p>
          <p>Total: $<?php echo number_format($product['price'] * $product['quantity'], 2); ?></p>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="summary">
      <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
      <p><strong>Shipping Fee:</strong> $<?php echo number_format($shippingFee, 2); ?></p>
      <p><strong>Total Amount:</strong> $<?php echo number_format($totalAmount, 2); ?></p>
    </div>

    <form method="POST">
      <button onclick: window.type="submit" class="checkout-btn">Place Order</button>
    </form>
  <?php else: ?>
    <p>No items in your cart.</p>
  <?php endif; ?>

  <div style="margin-top: 40px;">
  <h2>Choose Delivery Location</h2>
  <div id="map" style="width: 100%; height: 300px; border-radius: 10px;"></div>
  <p id="address-display" style="margin-top: 10px; font-weight: bold;">Click on the map to select your delivery address.</p>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([10.6433, 122.2355], 13); // Default center

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker;

  map.on('click', function (e) {
    const { lat, lng } = e.latlng;

    if (marker) {
      marker.setLatLng([lat, lng]);
    } else {
      marker = L.marker([lat, lng], { draggable: true }).addTo(map);
    }

    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
      .then(res => res.json())
      .then(data => {
        const address = data.display_name || "Address not found";
        document.getElementById('address-display').textContent = address;
      })
      .catch(() => {
        document.getElementById('address-display').textContent = "Error fetching address.";
      });
  });
</script>

</body>
</html>

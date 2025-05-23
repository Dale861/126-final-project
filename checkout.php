<?php
include 'connect.php';

// Assuming you have received order data from the checkout page (via POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetching customer details (for simplicity, let's assume it's already logged in)
    $customerID = 1; // This should come from your session or login logic

    // Fetching cart items and total
    $orderDate = date('Y-m-d H:i:s');
    $totalAmount = $_POST['totalAmount'];

    // Insert order into the Orders table
    $stmt = $pdo->prepare("INSERT INTO Orders (customerID, orderDate, totalAmount) VALUES (?, ?, ?)");
    $stmt->execute([$customerID, $orderDate, $totalAmount]);

    // Get the last inserted order ID
    $orderID = $pdo->lastInsertId();

    // Insert each order item into the OrderItems table
    foreach ($_POST['cartItems'] as $item) {
        $productID = $item['productID'];
        $quantity = $item['quantity'];
        $priceAtOrder = $item['price'];

        $stmt = $pdo->prepare("INSERT INTO OrderItems (orderID, productID, quantity, priceAtOrder) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderID, $productID, $quantity, $priceAtOrder]);
    }

    // Optionally, you can send an email confirmation or display a success message
    echo "Order placed successfully!";
} else {
    echo "Invalid request!";
}
?>

<?php

session_start(); // Start the session
include 'connect.php'; // Include database connection

// Access customerID from session
if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];  // Get customerID from session
} else {
    // Redirect to login page if the user is not logged in
    header("Location: index.php");
    exit();
}

// Get shop ID from URL or default to 1
$shopID = isset($_GET['shopID']) ? (int)$_GET['shopID'] : 1;

// Store the shop ID in session for persistent use
$_SESSION['shopID'] = $shopID; // Save the shopID to session

// Fetch shop information
$shopQuery = "SELECT * FROM Shops WHERE ShopID = $shopID";
$shopResult = $mysqli->query($shopQuery);
$shop = null;

if ($shopResult && $shopResult->num_rows > 0) {
    $shop = $shopResult->fetch_assoc();
}

// Fetch categories
$categoryQuery = "SELECT * FROM categories";
$categoryResult = $mysqli->query($categoryQuery);

// Store categories in an array
$categories = [];
while ($category = $categoryResult->fetch_assoc()) {
    $categories[] = $category;
}

// Manually sort the categories in the order you want: Appetizers, Main Course, Drinks
$orderedCategories = [];
$order = ['Appetizer', 'Main Course', 'Drinks'];

foreach ($order as $catName) {
    foreach ($categories as $key => $category) {
        if ($category['name'] == $catName) {
            $orderedCategories[] = $category;
            unset($categories[$key]); // Remove the category once it's added to the ordered list
            break;
        }
    }
}
// Assuming the user is logged in, retrieve customerID from session or other method
$customerID = isset($_SESSION['customerID']) ? $_SESSION['customerID'] : 1;; // Example customer ID, replace with actual logic for a logged-in user

// Get the cart items for the customer
$cartQuery = "SELECT ci.cartItemID, p.itemName AS name, p.price, ci.quantity, p.image_url 
              FROM CartItems ci 
              JOIN Products p ON ci.productID = p.productID 
              WHERE ci.customerID = $customerID";
$result = $mysqli->query($cartQuery);
$cartItems = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
} else {
    // If no cart items found, show a message indicating the cart is empty
    $cartItems = []; // Empty cart
}

// Calculate the total amount
$cartCount = count($cartItems);
$totalAmount = 0;

foreach ($cartItems as $item) {
    if (isset($item['price']) && isset($item['quantity'])) {
        $totalAmount += $item['price'] * $item['quantity'];
    }
}

// Handle add to cart
if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productImage = $_POST['productImage'];
    $shopID = isset($_GET['shop']) ? (int)$_GET['shop'] : 1;

    // Check if the product is already in the cart
    $checkQuery = "SELECT * FROM CartItems WHERE customerID = $customerID AND productID = $productID";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // If the product is already in the cart, update the quantity
        $updateQuery = "UPDATE CartItems SET quantity = quantity + 1 WHERE customerID = $customerID AND productID = $productID";
        $mysqli->query($updateQuery);
    } else {
        // If the product is not in the cart, add it
        $insertQuery = "INSERT INTO CartItems (customerID, productID, quantity) VALUES ($customerID, $productID, 1)";
        $mysqli->query($insertQuery);
    }

    // Redirect back to the page after adding to cart
    header("Location: foodshoppage.php?shop=$shopID");
    exit();
}

// Handle decreasing quantity (minus button)
if (isset($_POST['decrease_quantity'])) {
    $cartItemID = $_POST['cartItemID'];  // Get the cartItemID to identify the item

    // First, fetch the current quantity of the item
    $quantityQuery = "SELECT quantity FROM CartItems WHERE cartItemID = $cartItemID AND customerID = $customerID";
    $quantityResult = $mysqli->query($quantityQuery);
    $quantityRow = $quantityResult->fetch_assoc();
    $currentQuantity = $quantityRow['quantity'];

    // If the quantity is greater than 1, decrease it
    if ($currentQuantity > 1) {
        $updateQuery = "UPDATE CartItems SET quantity = quantity - 1 WHERE cartItemID = $cartItemID AND customerID = $customerID";
        $mysqli->query($updateQuery);
    } else {
        // If the quantity is 1, remove the item from the cart
        $removeQuery = "DELETE FROM CartItems WHERE cartItemID = $cartItemID AND customerID = $customerID";
        $mysqli->query($removeQuery);
    }

    // Redirect back to the page after removing/updating the cart
    $shopID = isset($_GET['shop']) ? (int)$_GET['shop'] : 1;
    header("Location: foodshoppage.php?shop=$shopID");
    exit();
}

// Handle increasing quantity (plus button)
if (isset($_POST['increase_quantity'])) {
    $cartItemID = $_POST['cartItemID'];  // Get the cartItemID to identify the item

    // Increase the quantity by 1
    $updateQuery = "UPDATE CartItems SET quantity = quantity + 1 WHERE cartItemID = $cartItemID AND customerID = $customerID";
    $mysqli->query($updateQuery);

    // Redirect back to the page after updating the cart
    $shopID = isset($_GET['shop']) ? (int)$_GET['shop'] : 1;
    header("Location: foodshoppage.php?shop=$shopID");
    exit();
}
?>
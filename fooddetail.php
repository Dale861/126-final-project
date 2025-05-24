<?php
session_start(); // Start the session
include 'connect.php'; // Include database connection

// Check if productID is passed in the URL
if (isset($_GET['productID'])) {
    $productID = $_GET['productID']; // Get productID from URL
} else {
    // Redirect to shop page if no productID is found in the URL
    header("Location: foodshoppage.php");
    exit();
}

// Fetch product details based on productID
$productQuery = "SELECT * FROM Products WHERE productID = $productID";
$productResult = $mysqli->query($productQuery);
$product = null;

if ($productResult && $productResult->num_rows > 0) {
    $product = $productResult->fetch_assoc();
} else {
    // Redirect to shop page if no product is found
    header("Location: foodshoppage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="Img/deliveryIcon.png" type="image/png">
    <script src="script.js" defer></script>
    <title>Product Detail</title>
</head>
<body>
    <header>
        <nav id="logo">
            <img src="Img/deliveryIcon.png" alt="">
        </nav>
        <nav class="nav">
            <ul id="nav">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="restaurant.php">Restaurants</a></li>
                <li><a href="CheckoutPage.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section class="Product-Detail">
            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['itemName']; ?>">

            <div>
                <h2><?php echo $product['itemName']; ?></h2>
                <p><?php echo $product['description']; ?></p> <!-- Assuming there is a description field in your database -->
                <p>Php <?php echo number_format($product['price'], 2); ?></p>
                <div class="quantity-selector">
                    <button type="button" onclick="decreaseQuantity()">−</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button type="button" onclick="increaseQuantity()">+</button>
                </div>
                <button>Add To Cart</button>
            </div>

            <div class="selection">
                <label for="size">Select Size</label>
                <div class="size-options">
                    <input type="radio" name="size" value="1" checked> Small <br>
                    <input type="radio" name="size" value="2"> Medium <br>
                    <input type="radio" name="size" value="3"> Large <br>
                </div>
                <br><br>

                <label for="addons">Select Add-ons</label>
                <div class="addons-options">
                    <input type="checkbox" name="addons" value="1"> Extra Cheese <br>
                    <input type="checkbox" name="addons" value="2"> Extra Sauce <br>
                    <input type="checkbox" name="addons" value="3"> Extra Toppings <br>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

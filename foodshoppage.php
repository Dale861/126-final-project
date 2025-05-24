<?php
session_start(); // Start the session
include 'connect.php'; // Include database connection
include 'cart.php'; // Include cart logic

// Access customerID from session
if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];  // Get customerID from session
} else {
    // Redirect to login page if the user is not logged in
    header("Location: index.php");
    exit();
}

// Get shop ID from URL or default to 1
$shopID = isset($_GET['shop']) ? (int)$_GET['shop'] : 1;

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Food Shop</title>
  <link rel="stylesheet" href="foodshop.css"/>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <header class="main-header">
      <div class="logo-with-bg"><?php echo $shop ? htmlspecialchars($shop['shopName']) : 'Shop'; ?></div>
      <nav class="navbar">
        <ul>
          <li><a href="homepage.php">Home</a></li>
          <li><a href="restaurant.php">Restaurants</a></li>
          <li><a href="CheckoutPage.php">Cart</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <!-- Shop Banner -->
    <?php if ($shop): ?>
      <div class="shop-banner">
        <?php if (!empty($shop['image_url'])): ?>
          <img src="<?php echo htmlspecialchars($shop['image_url']); ?>" alt="<?php echo htmlspecialchars($shop['shopName']); ?>" class="shop-logo" />
        <?php endif; ?>
        <h2><?php echo htmlspecialchars($shop['shopName']); ?></h2>
      </div>
    <?php endif; ?>

    <!-- Categories -->
    <div class="categories-container">
      <?php if (count($orderedCategories) > 0): ?>
        <?php foreach ($orderedCategories as $category): ?>
          <div class="category">
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>
            <div class="product-list">
              <?php
              // Fetch products for this category filtered by shopID
              $categoryId = $category['category_id'];
              $productQuery = "SELECT * FROM products WHERE category_id = $categoryId AND shopID = $shopID";
              $productResult = $mysqli->query($productQuery);
              
              if ($productResult->num_rows > 0):
                while ($product = $productResult->fetch_assoc()):
              ?>
                <div class="product-item">
                  <a href="fooddetail.php?productID=<?php echo $product['productID']; ?>">
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['itemName']; ?>" />
                  </a>
                  <h3><?php echo $product['itemName']; ?></h3>
                  <p class="price">P<?php echo number_format($product['price'], 2); ?></p>
                  <form action="foodshoppage.php?shop=<?php echo $shopID; ?>" method="POST">
                    <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                    <input type="hidden" name="productName" value="<?php echo $product['itemName']; ?>">
                    <input type="hidden" name="productPrice" value="<?php echo $product['price']; ?>">
                    <input type="hidden" name="productImage" value="<?php echo $product['image_url']; ?>">
                    <button type="submit" name="add_to_cart">+</button>
                  </form>
                </div>
              <?php endwhile; ?>
              <?php else: ?>
                <p>No products available in this category.</p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>

  <!-- Cart Section -->
  <div class="cartTab">
    <h1>Shopping Cart</h1>
    <div class="listCart">
      <?php
      $total = 0; // Initialize total price variable
      if ($cartCount > 0): ?>
        <?php foreach ($cartItems as $product): 
          $productTotal = $product['price'] * $product['quantity'];
          $total += $productTotal; // Add to total
        ?>
          <div class="item">
            <div class="image">
              <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <div class="name"><?php echo $product['name']; ?></div>
            <div class="totalPrice">P<?php echo number_format($productTotal, 2); ?></div>
            <div class="quantity">
              <form action="foodshoppage.php?shop=<?php echo $shopID; ?>" method="POST">
                <input type="hidden" name="cartItemID" value="<?php echo $product['cartItemID']; ?>">
                <button type="submit" name="decrease_quantity">-</button>
              </form>
              <span><?php echo $product['quantity']; ?></span>
              <form action="foodshoppage.php?shop=<?php echo $shopID; ?>" method="POST">
                <input type="hidden" name="cartItemID" value="<?php echo $product['cartItemID']; ?>">
                <button type="submit" name="increase_quantity">+</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Your cart is empty. Add some items to start shopping!</p>
      <?php endif; ?>
    </div>
    <div class="totalAmount">
      <h3>Total: P<?php echo number_format($total, 2); ?></h3>
    </div>
    <div class="btn">
      <button class="checkOut" onclick="location.href='CheckoutPage.php'">CHECKOUT</button>
    </div>
  </div>

</body>
</html>

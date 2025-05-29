<?php
include 'Backend/fetch_foodshop.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Food Shop</title>
  <link rel="icon" href="Img/deliveryIcon.png" type="image/png">
  <link rel="stylesheet" href="CSS/styles.css"/>
  <link rel="stylesheet" href="CSS/foodshop.css"/>
  
</head>
<body>

  <div class="container">
    <!-- Header -->
    <header>
        <nav id="logo"> 
            <img src="Img/deliveryIcon.png" alt="Logo">
        </nav>
        <nav class="nav">
            <ul id="nav">
                <li><a href="homepage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'homepage.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="restaurant.php" class="<?= basename($_SERVER['PHP_SELF']) == 'restaurant.php' ? 'active' : '' ?>">Shops</a></li>
                <li><a href="CheckoutPage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'CheckoutPage.php' ? 'active' : '' ?>">Cart</a></li>
                <li><a href="Accountpage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Accountpage.php' ? 'active' : '' ?>">My Profile</a></li>
                <li><a href="logout.php" class="<?= basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : '' ?>">Logout</a></li>
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
                 
                  <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['itemName']; ?>" />
                  
                  <h3><?php echo $product['itemName']; ?></h3>
                  <p class="price">P<?php echo number_format($product['price'], 2); ?></p>
                  <form action="foodshoppage.php?shopID=<?php echo $shopID; ?>" method="POST">
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
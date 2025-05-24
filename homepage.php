<?php
session_start();  // Start the session
include("connect.php");  // Include the database connection file

if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];  // Get customerID from session
} else {
    // Redirect to login page if the user is not logged in
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>

    <!-- Favicon (Coffee Icon) -->
    <link rel="icon" href="Img/Coffee-icon.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main>
    <header>
        <nav id="logo"> 
            <img src="Img/Coffee-icon.png" alt="Logo">
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

    <div style="text-align:center; padding:15%;">
      <p style="font-size:50px; font-weight:bold;">
          Hello  <?php 
           if(isset($_SESSION['email'])){
               $email = $_SESSION['email'];
               $query = mysqli_query($mysqli, "SELECT customers.* FROM `customers` WHERE customers.email='$email'");
               while($row = mysqli_fetch_array($query)){
                   echo $row['fname'].' '.$row['lname'];
                }
            }
          ?>
       :)
      </p>
   
    <!-- Location and Food Selection Section -->
    <section class="LocationAPI">
        <h2>Where Should we deliver your Food?</h2>
        <p>Search your location to find nearby food options.</p>
        <div class="search-bar">
            <input type="text" placeholder="Search your location...">
            <button>Search</button>
        </div>
    </section>

    <section class="Restaurant-SignUp">
        <img src="Img/MiagaoChurch.jpg" alt="Miagao Church">
    </section>

    <section class="Food-Selection">
        <h2>Ano gusto mo kaonon?</h2>
        <div class="food-grid">
            <div class="food-card">
                <img src="Img/CoffeeCup.jpg" alt="Snacks">
                <p>Snacks</p>
            </div>
            <div class="food-card">
                <img src="Img/Chocolate.jpg" alt="Meals">
                <p><strong>Meals</strong><br><span>Kaon na ta!</span></p>
            </div>
            <div class="food-card">
                <img src="Img/Chocolate.jpg" alt="Dessert">
                <p>Dessert</p>
            </div>
        </div>
    </section>

    <section class="Shops">
      <h2>Diin mo gusto mag bakal?</h2>
      <div class="shop-grid">
        <div class="shop-item">
          <a href="foodshoppage.php?shop=2"> <!-- Kubo shopID = 2 -->
            <img src="Img/Kubo.jpg" alt="Kubo Resto"></a>
            <p><strong>Kubo Resto</strong> is chuchuchu</p>
        </div>
        <div class="shop-item">
          <a href="foodshoppage.php?shop=1"> <!-- Vineyard shopID = 1 -->
            <img src="Img/Vineyard.jpg" alt="Vineyard"></a>
            <p><strong>Vineyard</strong> is chuchuchu</p>
        </div>
      </div>
    </section>

    <section class="Reviews">
        <h2>Reviews</h2>
        <div class="review-grid">
          <div class="review-card">
            <p>"Namit namit gidya"</p>
            <p>- Cedric</p>
          </div>
          <div class="review-card">
            <p>"Ugh kanamit"</p>
            <p>- Luis</p>
          </div>
          <div class="review-card">
            <p>"Shet isa pa"</p>
            <p>- Dale</p>
          </div>
        </div>
    </section>
      
    <section class="Footer-Section">
        <h2>Section heading</h2>
        <button>Button</button>
        <button class="secondary">Secondary button</button>
        <footer>
          <p>Site name</p>
          <div class="footer-links">
            <ul>
              <li>Ad</li>
              <li>Ad</li>
              <li>Ad</li>
            </ul>
            <ul>
              <li>Ad</li>
              <li>Ad</li>
              <li>Ad</li>
            </ul>
          </div>
        </footer>
    </section>
  </main>

<script src="script.js"></script>
</body>
</html>

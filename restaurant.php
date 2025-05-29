<?php
include 'Backend/fetch_shops.php'; // Include the PHP script to fetch shop data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shops</title>

    <link rel="icon" href="Img/deliveryIcon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="CSS/styles.css">

    <!-- Leaflet.js CSS (For map styling) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>

<main>
    <header>
        <nav id="logo">
            <img src="Img/deliveryIcon.png" alt="Logo">
        </nav>
        <nav class="nav">
            <ul id="nav">
                <li><a href="homepage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'homepage.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="restaurant.php" class="<?= basename($_SERVER['PHP_SELF']) == 'restaurant.php' ? 'active' : '' ?>">Shops</a></li>
                <li><a href="CheckoutPage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'CheckoutPage.php' ? 'active' : '' ?>">Cart</a></li>
                <li><a href="Accountpage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Accountpage.php' ? 'active' : '' ?>">Account</a></li>
                <li><a href="logout.php" class="<?= basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : '' ?>">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Shop Listings -->
    <section class="Shop-Listings">
        <h2>Available Shops</h2>
        <div class="shop-grid">
            <?php
            // Fetch shops from the database
            $query = mysqli_query($mysqli, "SELECT * FROM shops");
            while($row = mysqli_fetch_array($query)){
                echo '<div class="shop-item">';
                echo '<a href="foodshoppage.php?shopID=' . $row['shopID'] . '">';
                echo '<img src="' . $row['image'] . '" alt="' . $row['shopName'] . '"></a>';
                echo '<p><strong>' . $row['shopName'] . '</strong><br>' . $row['location'] . '</p>';
                echo '</div>';

            }
            ?>
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
                  <div class="review-card">
                    <p>"Balutin mo ako"</p>
                    <p>- Stefan</p>
                </div>
                    <div class="review-card">
                    <p>"Monster"</p>
                    <p>- Eryl</p>
                </div>
            </div>
        </section>
</main>


</body>
</html>

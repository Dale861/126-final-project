<?php
include 'Backend/fetch_homepage.php'; // Include the PHP script to fetch homepage data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>


    <link rel="icon" href="Img/deliveryIcon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="CSS/styles.css">

    <!-- Leaflet.js CSS (For map styling) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <script src="https://cdn.lordicon.com/lordicon.js"></script>
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
    <div id="loading-screen" style="display: <?php echo $showLoading ? 'flex' : 'none'; ?>;">
        <div class="loading-content">
    <div class="delivery-time">Estimated Delivery<br><strong><?php echo $estimatedDeliveryTime; ?></strong></div>
    <div class="clock-icon">
      <lord-icon
        src="https://cdn.lordicon.com/warimioc.json"
        trigger="loop"
        state="loop-oscillate"
        style="width:250px;height:250px">
      </lord-icon>
    </div>
    <div class="progress-section">
      <div class="progress-bar">
        <div class="progress-bar-fill" id="progress-bar"></div>
      </div>
      <div class="loading-text" id="loading-text">LOADING... 0%</div>
    </div>
    <div class="order-details">
      <p>Order Number: <strong><?php echo $orderID; ?></strong></p>
      <p>Total Amount: <strong><?php echo number_format($totalAmount, 2); ?></strong></p>
    </div>

    <div id="order-received-section" style="display: none;">
        <p>Your order has arrived!</p>
        <button id="order-received-btn" onclick="orderReceived()">Order Received</button>
    </div>

</div>
</div>
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
        <div class="search-container">
            <input type="text" id="search-location" placeholder="Search your location..." onfocus="showMap()">
        </div>

        <!-- Map container (Initially hidden) -->
        <div id="map-container" style="display: block;">
            <div id="map-homepage" style="height: 400px;"></div>
        </div>

        <!-- Hidden input to store selected address -->
        <input type="hidden" id="user-address" name="address" />

        <!-- Confirmation button (Initially hidden) -->
        <button id="confirm-button" style="display: none;" onclick="confirmAddress()">Confirm Address</button>

        <!-- Image Section -->
        <section>
            <img src="Img/MiagaoChurch.jpg" alt="Miagao Church">
        </section>

        <section class="Food-Selection">
            <h2>Ano gusto mo kaonon?</h2>
            <div class="food-grid">
                <div class="food-card">
                    <img src="Img/10.png" alt="Snacks">
                    <p>Snacks</p>
                </div>
                <div class="food-card">
                    <img src="Img/4.png" alt="Meals">
                    <p><strong>Meal</strong>
                </div>
                <div class="food-card">
                    <img src="Img/K7.png" alt="Dessert">
                    <p>Dessert</p>
                </div>
            </div>
        </section>

        <section class="Shops">
            <h2>Diin mo gusto mag bakal?</h2>
            <div class="shop-grid">
                <div class="shop-item">
                    <a href="foodshoppage.php?shopID=2"> <!-- Kubo shopID = 2 -->
                        <img src="Img/Kubo.jpg" alt="Kubo Resto"></a>
                    <p><strong>Kubo Resto</strong></p>
                </div>
                <div class="shop-item">
                    <a href="foodshoppage.php?shopID=1"> <!-- Vineyard shopID = 1 -->
                        <img src="Img/Vineyard.jpg" alt="Vineyard"></a>
                    <p><strong>Vineyard</strong></p>
                </div>
            </div>
        </section>

        <section class="Reviews">
            <h2>Reviews</h2>
            <div class="review-grid">
                <div class="review-card">
                    <p>"Fast Delivery"</p>
                    <p>- Cedric</p>
                </div>
                <div class="review-card">
                    <p>"Satisfied"</p>
                    <p>- Luis</p>
                </div>
                <div class="review-card">
                    <p>"Will always use this app"</p>
                    <p>- Dale</p>
                </div>
            </div>
        </section>

    </main>

    <!-- OpenStreetMap -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const loadingScreen = document.getElementById('loading-screen');
    const orderReceivedSection = document.getElementById('order-received-section');
    const orderReceivedBtn = document.getElementById('order-received-btn');
    const progressBar = document.getElementById('progress-bar');
    const loadingText = document.getElementById('loading-text');
    const estimatedTimeText = document.querySelector('.delivery-time strong');
    
    let estimatedTime = 30; 
    if (loadingScreen.style.display === 'flex') {
        let progress = 0;
        const progressBar = document.getElementById('progress-bar');
        const loadingText = document.getElementById('loading-text');

        const interval = setInterval(() => {
            if (progress < 100) {
                progress++;
                progressBar.style.width = progress + '%';
                loadingText.textContent = `LOADING... ${progress}%`;
                estimatedTime = Math.max(0, 30 - (0.3 * progress)); // Ensure time doesn't go below 0 minutes
                estimatedTimeText.innerHTML = `${estimatedTime.toFixed(1)} Mins`; // Update the time at the top
            } else {
                clearInterval(interval);
                loadingText.textContent = `Your Delivery is here!`;

                // Show the "Order Received" button when delivery is here
                orderReceivedSection.style.display = 'block';
                
                // Optionally, hide the progress bar when delivery is confirmed
                progressBar.style.display = 'none';
            }
        }, 50); // Faster animation (50ms instead of 100ms)
    }
});

// Function to hide the loading screen when the customer confirms the order is received
function orderReceived() {
    const loadingScreen = document.getElementById('loading-screen');
    loadingScreen.style.display = 'none';  // Hide the loading screen
}
  
    document.addEventListener('DOMContentLoaded', function () {
        initMap('map-homepage');  // Initialize the map with the element ID 'map-homepage'
    });

    function showMap() {
        // Display the map container
        document.getElementById('map-container').style.display = 'block';

        // Geocoding logic
        const location = document.getElementById('search-location').value;
        if (!location) {
            return;  // No alert, just return if location is empty
        }

        // Fetch coordinates from the location
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const lat = data[0].lat;
                    const lon = data[0].lon;
                    initMap('map-homepage', lat, lon);  // Update map with the location's coordinates
                } else {
                    document.getElementById('address-display').textContent = "Location not found.";
                }
            })
            .catch(() => {
                document.getElementById('address-display').textContent = "Error fetching location.";
            });
    }

    function confirmAddress() {
        const address = document.getElementById('search-location').value;

        // Ensure the address is not empty before submitting
        if (address === "" || address === "Error fetching address.") {
            alert("Please select a valid address.");
            return;  // Prevent form submission if the address is empty
        }

        // Store the address in the hidden input
        document.getElementById('user-address').value = address;

        // Now, directly submit the form via AJAX
        submitAddress(address);
    }

    function submitAddress(address) {
        // Create a new FormData object to send the data via AJAX
        const formData = new FormData();
        formData.append('address', address);

        // Send the data to the server via AJAX (POST request)
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Display the server response (address update success message)
            alert(data);
        })
        .catch(error => {
            console.error("Error submitting address:", error);
            alert("Error submitting address.");
        });
    }

    function initMap(mapElementId, defaultLat = 10.6433, defaultLng = 122.2355, zoom = 13) {
        // Initialize the map if not already initialized
        let map = L.map(mapElementId).setView([defaultLat, defaultLng], zoom);  // Set the default center

        // Add the tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Create a draggable marker
        let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Handle map click event to move the marker
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;
            marker.setLatLng([lat, lng]);

            // Fetch the address using reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    const address = data.display_name || "Address not found";
                    document.getElementById('search-location').value = address;

                    // Store the address in the hidden input field
                    document.getElementById('user-address').value = address;

                    // Show the confirmation button
                    document.getElementById('confirm-button').style.display = 'block';
                })
                .catch((error) => {
                    console.error("Error fetching address:", error);
                    document.getElementById('search-location').value = "Error fetching address.";
                });
        });
    }
    </script>

</body>
</html>

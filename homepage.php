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

// Handle the form submission and update the address in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];  // Get the address from the form

    // Check if the address is empty
    if (empty($address)) {
        // If the address is empty, set a default address or show an error
        echo "Error: Address cannot be empty.";
        exit();  // Stop the script execution
    }

    // Update the address for the customer in the database
    $stmt = $mysqli->prepare("UPDATE customers SET address = ? WHERE customerID = ?");
    $stmt->bind_param("si", $address, $customerID);
    $stmt->execute();

    // Optionally, redirect to another page or display a success message
    echo "Address updated successfully!";
    exit();  // End script execution after the update
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <!-- Favicon (Coffee Icon) -->
    <link rel="icon" href="Img/Coffee-icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">

    <!-- Leaflet.js CSS (For map styling) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

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

    <!-- OpenStreetMap -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
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

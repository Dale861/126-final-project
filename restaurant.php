<?php
include 'Backend/fetch_shops.php'; // Include the PHP script to fetch shop data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shops</title>

    <!-- Favicon (Coffee Icon) -->
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
                <li><a href="homepage.php">Home</a></li>
                <li><a href="restaurant.php" class="active">Shops</a></li>
                <li><a href="CheckoutPage.php">Cart</a></li> <!-- Correct link to cart page -->
                <li><a href="logout.php">Logout</a></li>
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

    <!-- Map Section -->
    <section class="LocationAPI">
        <h2>Find a Location</h2>
        <div class="search-bar">
            <input type="text" id="search-location" placeholder="Search your location..." onfocus="showMap()">
            <button onclick="searchLocation()">Search</button>
        </div>
        <div id="map-container" style="display: none;">
            <div id="map-homepage" style="height: 400px;"></div>
        </div>
    </section>

    <!-- Footer Section -->
    <section class="Footer-Section">
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

// Function to show the map based on the location search
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

// Function to initialize the map
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
            })
            .catch((error) => {
                console.error("Error fetching address:", error);
                document.getElementById('search-location').value = "Error fetching address.";
            });
    });
}

// Optional: Add functionality for searching and confirming the address
function searchLocation() {
    const location = document.getElementById('search-location').value;
    if (location) {
        alert(`Searching for: ${location}`);
    }
}
</script>

</body>
</html>

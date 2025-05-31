<?php
include 'Backend/fetch_profile.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title> <!-- Updated title -->
    <link rel="icon" href="Img/deliveryIcon.png" type="image/png">
    <link rel="stylesheet" href="CSS/styles.css">

</head>
<body>
    <main>
    <header>
        <div class="back-button" onclick="goBack()">
        </div>
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

    <div class="profile-container">
        <div class="profile-title">
            My Profile <!-- Updated title here -->
            <div class="info-icon" onclick="showInfo()">
                <span>i</span>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="profile_edit.php">
            <label class="form-label" for="first-name">First name</label>
            <input type="text" id="first-name" name="first_name" class="form-input" 
                   value="<?php echo htmlspecialchars($customer['fname']); ?>" disabled>

            <label class="form-label" for="last-name">Last name</label>
            <input type="text" id="last-name" name="last_name" class="form-input" 
                   value="<?php echo htmlspecialchars($customer['lname']); ?>" disabled>

            <!-- Save button removed as per your request -->
        </form>

        <div class="section-title">Email</div>

        <form method="POST" action="profile_edit.php">
            <input type="email" id="email" name="email" class="form-input" 
                   value="<?php echo htmlspecialchars($customer['email']); ?>" disabled>

            <div class="verified-badge">
                <div class="verified-icon"></div>
                <span class="verified-text">Verified</span>
            </div>

            <!-- Save button removed as per your request -->
        </form>

            <form method="POST" action="profile_edit.php">
                <label class="form-label" for="current-password">Password</label>
                <input type="password" id="current-password" name="current_password" class="form-input" value="*******" disabled>


                <!-- Save button removed as per your request -->
            </form>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function showInfo() {
            alert('This is your profile information. You can view and edit your personal details here.');
        }

        // Client-side password confirmation validation
        document.getElementById('confirm-password').addEventListener('input', function() {
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = this.value;

            if (newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        <?php if (!empty($message)): ?>
        setTimeout(function() {
            const messageElement = document.querySelector('.message');
            if (messageElement) {
                messageElement.style.transition = 'opacity 0.5s';
                messageElement.style.opacity = '0';
                setTimeout(() => messageElement.remove(), 500);
            }
        }, 5000);
        <?php endif; ?>
    </script>
    </main>
</body>
</html>
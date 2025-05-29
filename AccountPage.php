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
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #ffffff;
        }

        .header {
            background-color: #d9d9d9;
            height: 181px;
            width: 100%;
            position: relative;
        }

        .back-button {
            position: absolute;
            left: 69px;
            top: 91px;
            width: 68px;
            height: 2px;
            background-color: #000000;
            cursor: pointer;
        }

        .back-button::before {
            content: '';
            position: absolute;
            width: 12px;
            height: 2px;
            background-color: #000000;
            transform: rotate(45deg);
            top: -4px;
            left: 0;
        }

        .back-button::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 2px;
            background-color: #000000;
            transform: rotate(-45deg);
            top: 4px;
            left: 0;
        }

        nav {
            position: absolute;
            top: 50px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .nav ul {
            display: flex;
            list-style: none;
        }

        .nav ul li {
            margin: 0 20px;
        }

        .nav a {
            text-decoration: none;
            color: #000;
            font-size: 18px;
            font-weight: bold;
        }

        .nav a.active {
            color: #0090ff;
        }

        .profile-container {
            width: 778px;
            min-height: 687px;
            background-color: #ffffff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            margin: 86px auto;
            padding: 32px;
            position: relative;
        }

        .profile-title {
            font-size: 24px;
            font-weight: 700;
            color: #000;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }

        .info-icon {
            width: 24px;
            height: 24px;
            background-color: #fff;
            border: 1px solid #000;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            cursor: pointer;
        }

        .info-icon span {
            font-size: 14px;
            font-weight: 400;
            color: #000;
        }

        .form-label {
            font-size: 16px;
            color: rgba(0, 0, 0, 0.5);
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            width: 100%;
            height: 49px;
            background-color: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 8px 15px;
            font-size: 18px;
            margin-bottom: 20px;
            pointer-events: none; /* Disables editing */
        }

        .form-input:focus {
            outline: none;
            border-color: #0090ff;
        }

        .save-btn {
            width: 92px;
            height: 49px;
            background-color: #0090ff;
            border: 1px solid #0090ff;
            border-radius: 12px;
            font-size: 20px;
            color: #fff;
            cursor: not-allowed; /* Disable the button */
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .save-btn:hover {
            background-color: #0070cc;
            border-color: #0070cc;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            height: 23px;
            background-color: rgba(0, 144, 255, 0.53);
            border: 1px solid rgba(230, 230, 230, 0.53);
            border-radius: 11px;
            padding: 0 10px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .verified-icon {
            width: 14px;
            height: 14px;
            background-color: #00008b;
            border-radius: 7px;
            position: relative;
            margin-right: 9px;
        }

        .verified-icon::before {
            content: '✓';
            position: absolute;
            color: #fff;
            font-size: 10px;
            top: 0;
            left: 2px;
        }

        .verified-text {
            font-size: 14px;
            color: #00008b;
        }

        .password-section {
            border-top: 1px solid #e6e6e6;
            padding-top: 30px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="back-button" onclick="goBack()"></div>
        <nav class="nav">
            <ul id="nav">
                <li><a href="homepage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'homepage.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="restaurant.php" class="<?= basename($_SERVER['PHP_SELF']) == 'restaurant.php' ? 'active' : '' ?>">Shops</a></li>
                <li><a href="CheckoutPage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'CheckoutPage.php' ? 'active' : '' ?>">Cart</a></li>
                <li><a href="Accountpage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Accountpage.php' ? 'active' : '' ?>">My Profile</a></li> <!-- Updated label to "My Profile" -->
                <li><a href="logout.php" class="<?= basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : '' ?>">Logout</a></li>
            </ul>
        </nav>
    </div>

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
</body>
</html>
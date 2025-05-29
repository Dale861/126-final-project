<?php
include 'Backend/fetch_profile.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Edit Page</title>
    <link rel="icon" href="Img/deliveryIcon.png" type="image/png">
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
            line-height: 30px;
            color: #000000;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }
        
        .info-icon {
            width: 24px;
            height: 24px;
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            cursor: pointer;
        }
        
        .info-icon span {
            font-size: 14px;
            font-weight: 400;
            color: #000000;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-label {
            font-size: 16px;
            font-weight: 400;
            line-height: 20px;
            color: rgba(0, 0, 0, 0.5);
            margin-bottom: 8px;
            display: block;
        }
        
        .form-input {
            width: 454px;
            height: 49px;
            background-color: #ffffff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 8px 15px;
            font-size: 18px;
            font-weight: 400;
            line-height: 30px;
            color: #000000;
            margin-bottom: 20px;
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
            font-weight: 400;
            line-height: 25px;
            color: #ffffff;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        
        .save-btn:hover {
            background-color: #0070cc;
            border-color: #0070cc;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 700;
            line-height: 30px;
            color: #000000;
            margin-bottom: 20px;
            margin-top: 30px;
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
            color: #ffffff;
            font-size: 10px;
            top: 0px;
            left: 2px;
        }
        
        .verified-text {
            font-size: 14px;
            font-weight: 400;
            line-height: 17px;
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
    </div>
    
    <div class="profile-container">
        <div class="profile-title">
            My profile
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
                   value="<?php echo htmlspecialchars($customer['fname']); ?>" required>
            
            <label class="form-label" for="last-name">Last name</label>
            <input type="text" id="last-name" name="last_name" class="form-input" 
                   value="<?php echo htmlspecialchars($customer['lname']); ?>" required>
            
            
            <button type="submit" name="save_personal_info" class="save-btn">Save</button>
        </form>
        
        <div class="section-title">Email</div>
        
        <form method="POST" action="profile_edit.php">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input" 
                   value="<?php echo htmlspecialchars($customer['email']); ?>" required>
            
            <div class="verified-badge">
                <div class="verified-icon"></div>
                <span class="verified-text">Verified</span>
            </div>
            
            <button type="submit" name="save_email" class="save-btn">Save</button>
        </form>

        <div class="password-section">
            <div class="section-title">Change Password</div>
            
            <form method="POST" action="profile_edit.php">
                <label class="form-label" for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current_password" class="form-input" required>
                
                <label class="form-label" for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" class="form-input" 
                       minlength="6" required>
                
                <label class="form-label" for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="confirm_password" class="form-input" 
                       minlength="6" required>
                
                <button type="submit" name="save_password" class="save-btn">Save</button>
            </form>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
        
        function showInfo() {
            alert('This is your profile information. You can edit and save your personal details here.');
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

        // Auto-hide messages after 5 seconds
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
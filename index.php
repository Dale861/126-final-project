<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>

    <link rel="icon" href="Img/deliveryIcon.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="CSS/signUp-style.css">
</head>
<body>
  <main>
    <header>
        <nav>
          <button class="open-button" id="openSignUp" onclick="openForm()">Sign up</button>          
        </nav>
    </header>

    <!-- Sign-up form container -->
    <div class="signup-container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
    <form method="post" action="register.php">
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="fname" id="fname" placeholder="First Name" required>
          <label for="fname">First Name</label>
        </div>
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="lname" id="lname" placeholder="Last Name" required>
          <label for="lname">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
      <input type="submit" class="btn" value="Sign Up" name="signUp">
    </form>

      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <!-- Sign-in form container -->
    <div class="signin-container" id="signIn" style="display:none;">
      <h1 class="form-title">Sign In</h1>
      <form method="post" action="register.php">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>      
        </div>
        <p class="recover">
          <a href="#">Recover Password</a>
        </p>
        <input type="submit" class="btn" value="Sign In" name="signIn">
      </form>
      
      <div class="links">
        <p>Don't have account yet?</p>
        <button id="signUpButton">Sign Up</button>
      </div>
    </div>

    <!-- Location and Food Selection Section -->
    <section class="LocationAPI">
        <h2>Where Should we deliver your Food?</h2>
        <p>Search your location to find nearby food options.</p>
        <div class="search-bar">
            <input type="text" placeholder="Search your location...">
            <button>Search</button>
        </div>
    </section>

    <!-- Food and Restaurant Section -->
    <section class="Restaurant-SignUp">
        <img src="Img/MiagaoChurch.jpg" alt="Miagao Church">
    </section>

    <!-- Food Selection Section -->
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

  
  </main>

  <!-- Link to external script file -->
  <script src="JS/script.js"></script>

</body>
</html>

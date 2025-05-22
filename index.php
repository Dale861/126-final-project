<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>

  <header>
      <nav id="logo"> 
          <img src="Img/Coffee-icon.png" alt="">
      </nav>
      <nav>
        <button class="open-button" id="openSignUp" onclick=openForm()>Sign up</button>          
      </nav>
  </header>

  <main>  
    <div class="signup-container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="register.php"> <!--add onsubmit validate form-->
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Last Name</label>
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
      <p class="or">
        ----------or--------
      </p>
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

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
      <p class="or">
        ----------or--------
      </p>
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Don't have account yet?</p>
        <button id="signUpButton">Sign Up</button>
      </div>
    </div>
    <section class="LocationAPI">
        <h2>Where Should we deliver your Food?</h2>
        <p>Search your location to find nearby food options.</p>
        <div class="search-bar">
            <input type="text" placeholder="Search your location...">
            <button>Search</button>
        </div>
    </section>

    <section class="Map">
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
            <!-- ps. halin na sa fb ang Img src -->
            <img src="Img/kubo.jpg" alt="Kubo Resto">
            <p><strong>Kubo Resto</strong>is chuchuchu</p>
          </div>
          <div class="shop-item">
            <img src="Img/vnyrd.jpg" alt="Vinyard">
            <p><strong>Vinyard</strong> is a local restaurant in Miagao...</p>
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
</body>
</html>
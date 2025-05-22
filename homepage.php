<?php
// session_start();
include("connect.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="signUp-style.css">
</head>
<body>
  <main>
    <header>
        <nav id="logo"> 
            <img src="Img/Coffee-icon.png" alt="">
        </nav>
        <nav class="nav">
            <ul id="nav">
                <li><a href="">Home</a></li>
                <li><a href="">Restaurants</a></li>
                <li><a href="">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        
    </header>

    <div style="text-align:center; padding:15%;">
      <p  style="font-size:50px; font-weight:bold;">
          Hello  <?php 
       if(isset($_SESSION['email'])){
           $email=$_SESSION['email'];
           $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
           while($row=mysqli_fetch_array($query)){
               echo $row['firstName'].' '.$row['lastName'];
            }
        }
        ?>
       :)
    </p>
    
   
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
            <!-- ps. halin na sa fb ang Img src -->
            <img src="https://scontent.fcgy2-4.fna.fbcdn.net/v/t39.30808-6/302068729_456097433205339_1121063619204570159_n.jpg?_nc_cat=105&amp;ccb=1-7&amp;_nc_sid=6ee11a&amp;_nc_eui2=AeECkl9ZIuYSCbLhqrUjbu-DolM2jecTNQSiUzaN5xM1BHmbpFCUJTeCzB9Qn30ue6Kc24C_czMSzG7VtEF0MJFJ&amp;_nc_ohc=ZOVtAccaJAwQ7kNvwF1oGLk&amp;_nc_oc=AdnKyEMj3SvC_10qjT-E8cleCJBC8nY4H8Ad2hgAWrCOWZ_joPpCeNvm5Kyc0Zhsywg&amp;_nc_zt=23&amp;_nc_ht=scontent.fcgy2-4.fna&amp;_nc_gid=YXVC02lYGRKJbxVQlwPPCg&amp;oh=00_AfKNp4R78DesfiWiivJG38rZ9dymT1_4bq7cjFe8UDg0LA&amp;oe=68292D2A" alt="Kubo Resto">
            <p><strong>Kubo Resto</strong>is chuchuchu</p>
          </div>
          <div class="shop-item">
            <img src="https://scontent.fcgy2-2.fna.fbcdn.net/v/t39.30808-6/280529381_4526652207435039_8563210196956821114_n.jpg?_nc_cat=104&amp;ccb=1-7&amp;_nc_sid=6ee11a&amp;_nc_eui2=AeFLqgW-PQ4wq-rhdgqX2L6de60L8DtWZiZ7rQvwO1ZmJiF5Z-gt2JCyKPMc4-W_mS_vYlWaWlhkOoQn13skhwjh&amp;_nc_ohc=bp70ZAeSZJsQ7kNvwHWXg4H&amp;_nc_oc=Admxy533Nn77UJLhDdl0iWRfFiyh8g0UvpxF-ScitBCQExdPlbY9oHtGq_7iH1iDCOU&amp;_nc_zt=23&amp;_nc_ht=scontent.fcgy2-2.fna&amp;_nc_gid=-rvlLfGRBcgt1BpYmlfU7g&amp;oh=00_AfJ_zXD9fJ85XQffBVp4UrlVPjvmdKrn73ycTyw_KqBoZQ&amp;oe=68294F4D" alt="Vinyard">
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
  
</div>
<script src="script.js"></script>
</body>
</html>
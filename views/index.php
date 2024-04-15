<?php
  session_start();
  $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
  array_pop($relative_dir);
  $relative_dir = implode('\\', $relative_dir);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <link rel="icon" type="image/png" href="./assets/images/logo/logo1.png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My first L2 App</title>

  <link rel="stylesheet" href="assets/css/style.css">

  <!-- link to font awesome icons -->
  <link rel="stylesheet" href="assets/font/css/all.css">

  <!-- Scroll reveal link and typed js -->

  <script src="assets/node_modules/scrollreveal/dist/scrollreveal.min.js"></script>
  
  <script src="assets/node_modules/typed.js/dist/typed.umd.js"></script>

</head>
<body>
  <header>
    <div class="logo">
      <img src="assets/images/logo/logo5.jpg" alt="">
      <h3>Hackers <span>Hub</span></h3>
    </div>

    <nav>
      <ul>
        <li class="active home">
          <a href="#home" class="list">
            <span class="icon">
              <i class="fas fa-house"></i>
            </span>
            <span class="text">Home</span>
          </a>
        </li>
        <li class="about">
          <a href="#about" class="list">
            <span class="icon">
              <i class="fas fa-users"></i>
            </span>
            <span class="text">About Us</span>
          </a>
        </li>
        <li class="contact">
          <a href="#contact" class="list">
            <span class="icon">
              <i class="fas fa-phone"></i>
            </span>
            <span class="text">Contact</span>
          </a>
        </li>
        <li>
          <a href="" class="list">
            <span class="icon">
              <i class="fas fa-camera"></i>
            </span>
            <span class="text">Photos</span>
          </a>
        </li>
        <li>
          <a href="" class="list">
            <span class="icon">
              <i class="fas fa-gear"></i>
            </span>
            <span class="text">Settings</span>
          </a>
        </li>
      </ul>
    
    </nav>
  </header>

  <section class="section1" id="home">

    <span class="slanted-bg"></span>

    <div class="text-area"> 
      <h3>Welcome to Hackers Hub</h3>

      <p> We Foster <span class="multiple-text"></span></p>
    </div>

    <div class="form-section">
      <h3>Get Started</h3>
      <div class="buttons">
        <a href="/login">Login</a>
        <a href="/register">Sign Up</a>
      </div>
    </div>
  </section>

  <?php
    $path = '';
    include_once $relative_dir . '\views\include.php'

  ?>
  
</body>
</html>
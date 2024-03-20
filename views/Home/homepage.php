<?php
    session_start();

    if(!isset($_SESSION['userInfo'])){
        header("Location: ../auth/index.php");
        exit();
    }

    $userInfo = $_SESSION['userInfo'];
    include_once './../../controllers/dashctrl.php';

    $courses = selectProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My first L2 App</title>

  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/home.css">

  <!-- link to font awesome icons -->
  <link rel="stylesheet" href="../assets/font/css/all.css">

  <!-- Scroll reveal link and typed js -->

  <script src="../../node_modules/scrollreveal/dist/scrollreveal.min.js"></script>
  
  <script src="../../node_modules/typed.js/dist/typed.umd.js"></script>

</head>
<body>
  <header>
    <div class="logo">
      <img src="../assets/images/logo/logo5.jpg" alt="">
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
          <a href="./dashboard.php" class="list" title="dashboard">
            <span class="icon">
              <i class="fas fa-gear"></i>
            </span>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="./logout.php" class="list" title="Logout">
            <span class="icon">
              <i class="fas fa-power-off"></i>
            </span>
            <span class="text">Logout</span>
          </a>
        </li>
      </ul>
      <hr>
      <div class="userProfile">
        <h3 class="username"><?= $userInfo['name']?></h3>
        <img src="../assets/images//profile-pics/<?= $userInfo['profile_pic']?>" alt="">
      </div>
    
    </nav>
  </header>

  <section class="section1" id="home">

    <span class="slanted-bg"></span>

    <div class="text-area"> 
      <h3>Welcome to Hackers Hub</h3>

      <p> We Foster <span class="multiple-text"></span></p>
    </div>

    <div class="product-section">

      <h3>Our Courses</h3>
      <div class="products">

        <?php
          foreach($courses as $course):
        ?>
        <div class="productFrame">

          <img src="../assets/images/course_images/<?=$course['pic']?>" alt="">
          <div class="desc">

          </div>
        </div>

        <?php endforeach ?>
        <div class="category">
          category
        </div>
      
    </div>

  </section>
<?php

    $path = '../';
    include_once '../include.php'
?>
  
</body>
</html>
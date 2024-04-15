<?php
    session_start();

    $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($relative_dir);
    $relative_dir = implode('\\', $relative_dir);

    require_once $relative_dir . '\config\class_autoloader.inc.php';

    if(!isset($_SESSION['userInfo'])){
        header("Location: /index");
        exit();
    }

    $userInfo = $_SESSION['userInfo'];

    $obj = new Course_Controller();

    if(isset($_POST['cat'])){

      $catId = $_POST['hidden'];
      $cond = "cat_id = {$catId}";
      $courses = $obj->getCourses($cond);

    }
    else{
      $courses = $obj->getCourses();
    }

    $cat_obj = new Category_Controller();
    $categories = $cat_obj->getCategories();
    $len = count($_SESSION['sel-prods']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="assets/images/logo/logo1.png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My first L2 App</title>

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/home.css">

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
        <li class="contact">
          <a href="/cart" class="list" id="cont">
            <span class="icon">
              <i class="fas fa-cart-shopping"></i>
            </span>
            <span class="text">Checkout</span>
            <span id="counter"><?=$len?></span>
          </a>
        </li>
        <li>
          <a href="/dashboard" class="list" title="dashboard">
            <span class="icon">
              <i class="fas fa-gear"></i>
            </span>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="/logout" class="list" title="Logout">
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
        <img src="assets/images//profile-pics/<?= $userInfo['profile_pic']?>" alt="">
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
          if($courses):
          foreach($courses as $course):
        ?>
        <div class="productFrame">
          <a href="../assets/images/course_images/<?=$course['pic']?>" target="_blank" class="img_sec">
            <img src="../assets/images/course_images/<?=$course['pic']?>" alt=""> 
            
            <div class="desc">
              <form action="/buy" method="POST">
                <input type="submit" name="selected_prod" value="Buy">
                <input type="hidden" name="hidden" value="<?=$course['pd_id']?>">

                <??>

              </form>
          </div>
          </a>
          
          <span class="pd_name"><?=$course['pd_name']?></span>
          <span class="exists">
          <?php
            if(isset($_SESSION['exist-msg'])){
              $msg = $_SESSION['exist-msg'];
              if($msg['id'] == $course['pd_id']){
                echo $msg['msg'];
                unset($_SESSION['exist-msg']);
              }
              else{
                echo null;
              }
             
            }
          
          ?></span>
        </div>
        

        <?php endforeach;
        endif; ?>
        <div class="category-div">
          <div class="category">
            <span>Category</span>
            <i class="fas fa-chevron-down"></i>
            
          </div>
          
          <div class="cats">
              <?php
                if($categories):
                foreach($categories as $cat):
              ?>
              <form action="" method="POST">
                <input type="submit" name="cat" id="sub" value="<?= $cat['cat_name']?>">
                <input type="hidden" name="hidden" value="<?=$cat['cat_id']?>">
              </form>

              <?php
                endforeach;
                endif;
              ?>
            </div>
          
        </div>
      
    </div>

  </section>
<?php

    $path = '../';
    include_once $relative_dir . '\views\include.php'
?>
  
</body>
</html>
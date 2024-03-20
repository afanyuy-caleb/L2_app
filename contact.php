<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My first L2 App</title>

  <link rel="stylesheet" href="assets/css/style.css">

  <!-- link to font awesome icons -->
  <link rel="stylesheet" href="assets/font/css/all.css">
</head>
<body class="contact">
  <header>
    <div class="logo">
      <img src="assets/images/logo/logo5.jpg" alt="">
      <h3>Hackers Hub</h3>
    </div>
    <nav>
      <ul>
        <li>
          <a href="index.php" class="list">
            <span class="icon">
              <i class="fas fa-house"></i>
            </span>
            <span class="text">Home</span>
          </a>
        </li>
        <li>
          <a href="aboutUs.php" class="list">
            <span class="icon">
              <i class="fas fa-users"></i>
            </span>
            <span class="text">About Us</span>
          </a>
        </li>
        <li class="active">
          <a href="" class="list">
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

  <div class="text-area">
    <h3>Contact Us</h3>
    <p>Send to us your contribution, support, views and or even complaints
    </p>

    <div class="input-section">
      <form action="" method="POST">
        <div class="input">
          <input type="text" id="username" name="uname">
          <label for="username">User name</label>
        </div>

        <div class="input">
          <input type="email" id="email" name="email">
          <label for="email">Email address</label>
        </div> 

        <div class="input">
          <input type="text" name="subject" id="subject">
          <label for="subject">Enter the subject</label>
        </div> 
        <div class="input">
          <textarea name="text" id="text"></textarea>
          <label for="text">Message</label>
        </div>
        <button type="button" value="Send">Send </button>
        
      </form>

    </div>

    <div class="contact-details">
      contact Details
    </div>


  </div>
  
</body>
</html>
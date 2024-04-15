<?php

use function PHPSTORM_META\type;

  session_start();

  if(!isset($_SESSION['userInfo'])){
    header("Location: ../auth/index.php");
    exit();
  }

  $userInfo = $_SESSION['userInfo'];
  

  echo '<pre>';
  print_r($_SESSION['sel-prods']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="../assets/images/logo/logo1.png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>

</head>
<body>
  This is the checkout page

  <form action="" method="POST">
    <input type="submit" name="clear" value="Clear Cart">
  </form>
</body>
</html>
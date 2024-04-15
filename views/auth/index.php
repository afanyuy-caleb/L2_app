<?php
    session_start();

    $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($relative_dir);
    $relative_dir = implode('\\', $relative_dir);

    require_once $relative_dir . '\config\class_autoloader.inc.php';

    if(isset($_COOKIE['email'])){

        $email = $_COOKIE['email'];
        $pass = $_COOKIE['pass'];
    }
   
    if(isset($_POST['login'])){

        $user = new Login_Controller($_POST);
        $user->login();
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="../assets/images/logo/logo1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/reg.css">

    <!-- link to font awesome icons -->
    <link rel="stylesheet" href="../assets/font/css/all.css">

</head>
<body>

    <div class="divsec">
        <div class="image-section">
            <div class="textArea2">
                <span>
                    Life is a battle<br>
                    How you win that battle is based <br>
                    on how you consider your contestants
                    <br> !!!
                </span>
            </div>

        </div>
        <div class="form-section">
            <div class="logo">
            
                <img src="../assets/images/logo/logo5.jpg" alt="">
            </div>

            <form action="" method="POST" id="login">

                <h3>Login</h3>

                <?php 
                    if(isset($_SESSION['msg'])){
                        $msg = $_SESSION['msg'];
                    
                        $mg = $msg[1];
                        if($msg[0]){
                            echo "<p class='msg success-msg'>{$mg} </p>";
                        }
                        else{
                            echo "<p class='msg error-msg'>{$mg} </p>";
                            
                        }
                        unset($_SESSION['msg']);
                    }
                ?>
                
                <div class="input-sect">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-sect">
                    <input type="password" name="pass" id="pass" required>
                    <label for="pass">Password</label>
                </div>

                <div class="remember-forgot">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    <a href="">forgot password</a>
                </div>
            
                <input type="submit" name="login" value="Login">

                <p class="form-link">Don't yet have an account? <a href="/register">Register</a></p>
            </form>

        </div>
    </div>

</body>
</html>
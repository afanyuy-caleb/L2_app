<?php
    session_start();

    $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($relative_dir);
    $relative_dir = implode('\\', $relative_dir);

    require_once $relative_dir . '\config\class_autoloader.inc.php';

    if(isset($_POST['register'])){

        // Instantiate the user
  
        if($_FILES['prof-pic']['error'] != 0){
            $user = new Register_Controller($_POST, false);
        }
        else{           
            $user = new Register_Controller($_POST, $_FILES['prof-pic']);
        }
    
        $user->insertUser(); 
                
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="assets/images/logo/logo1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <link rel="stylesheet" href="../assets/css/reg.css">

    <!-- link to font awesome icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
</head>
<body>

    <div class="divsec">
        <div class="image-section">
            <div class="textArea">
                <h3>
                    Get Deep into the reality of Cyber Maliciousness
                </h3>

                <img src="../assets/images/profile-pics/default.webp" id="img-preview"/>
                <p>Profile image preview</p>
            </div>
            <div class="textArea2">
                <span>
                    Do not be afraid of Falling...<br>
                    Keep hoping you'll rise after the fall <br> !!!
                </span>
            </div>

        </div>
        <div class="form-section">
            <div class="logo">
            
                <img src="../assets/images/logo/logo5.jpg" alt="">
            </div>

            <form method="POST" enctype="multipart/form-data">

                
                <h3>Create your account now</h3>

                <p class="error-msg">
                    <?php echo $_SESSION['reg_failed']??NULL;
                        unset($_SESSION['reg_failed'])
                    ?>
                </p>

                <div class="input-sect">
                    <input type="text" name="username" id="name" required>
                    <label for="name">Username</label>
                </div>

                <p class="error-msg">
                    <?php echo $_SESSION['name_err']??NULL;
                        unset($_SESSION['name_err'])
                    ?>
                </p>

                <div class="input-sect">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>

                <p class="error-msg">
                    <?php echo $_SESSION['email_err']??NULL;
                        unset($_SESSION['email_err'])
                    ?>
                </p>
                <div class="input-sect">
                    <input type="password" name="pass" id="pass" required>
                    <label for="pass">Password</label>
                </div>
                <p class="error-msg">
                    <?php echo $_SESSION['pass_err']??NULL;
                        unset($_SESSION['pass_err'])
                    ?>
                </p>

                <div class="input-sect">
                    <input type="password" name="cpass" id="cpass" required>
                    <label for="cpass">Password confirmation</label>
                </div>

                <p class="error-msg">
                    <?php echo $_SESSION['cpass_err']??NULL;
                        unset($_SESSION['cpass_err'])
                    ?>
                </p>

                <div class="input-sect">
                    <input type="date" name="dob" id="date" required>
                    <label for="date" id="dob">Date of Birth</label>
                </div>

                <fieldset>
                    <legend>Profile picture</legend>
                    <input type="file" name="prof-pic" id="prof-pic" onchange="displayImage(this)">

                </fieldset>
               

                <p class="error-msg">
                    <?php echo $_SESSION['pic_err']??NULL;
                        unset($_SESSION['pic_err'])
                    ?>
                </p>

                <input type="submit" name="register" value="Register">

                <p class="form-link">Already have an account? <a href="/login">Login</a></p>
            </form>


        </div>

        
    </div>
    <script src="../assets/JS/imgPreview.js"></script>
</body>
</html>
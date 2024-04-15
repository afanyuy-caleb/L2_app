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

    if($userInfo['role_id'] != 1){

        header("Location: /homepage");
        exit();
    }

    $obj = new Course_Controller();
    $cat_obj = new Category_Controller();
    
    $_SESSION['list'] = $categories = $cat_obj->getCategories();
    $courses = $obj->getCourses();

    if(isset($_POST['add']) && isset($_FILES['course_img']['name'])){

        if($_POST['option'] === "edit"){
            $obj->updateFile($_POST, $_FILES['course_img']);
    
        }
        else{
            $obj->addFile($_POST, $_FILES['course_img']);
        }
    
    }
    else if(isset($_POST['delete'])){
        $obj->deleteFile($_POST['hiddenID']);
    
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="assets/images/logo/logo1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/css/dashboard.css">
    
    <!-- link to font awesome icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

    <header>
        <div class="logo">
            <img src="assets/images/logo/logo5.jpg" alt="">
            <h3>Hackers <span>Hub</span></h3>
        </div>

        <div class="search-bar">
            <form action="">
                
                <input type="text" name="search" placeholder="Search activity">

            </form>
            <div class="icon">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <div class="userProfile">

            <h3 class="username"><?= $userInfo['name']?></h3>
            <img src="assets/images//profile-pics/<?= $userInfo['profile_pic']?>" alt="">
        </div>
    </header>

    <main>
        <nav>
            <div class="icons">

                <div class="navLink">
                    <a href="/homepage">
                        <i class="fas fa-home"></i>

                    </a>
                    <span>
                        Home
                    </span>
                </div>
                <div class="navLink">
                    <a href="../homepage.php#about">
                        <i class="fas fa-user"></i>
                    </a>
                    <span>
                        About Us
                        
                    </span>
                </div>
                <div class="navLink">
                    <a href="./homepage.php#contact">
                        <i class="fas fa-phone"></i>
                    </a>
                    <span>
                        Contact
                    </span>
                </div>
                <div class="navLink">
                    <a href="">
                        <i class="fas fa-splotch"></i>
                    </a>
                    <span>
                        Gradings
                    </span>
                </div>
                <div class="navLink">
                    <a href="">
                        <i class="fas fa-bell"></i>
                    </a>
                    <span>
                        Notifs
                    </span>
                </div>
                
            </div>

            <div class="navLink">
                <a href="/logout">
                    <i class="fas fa-power-off"></i>

                </a>
                <span>
                    Logout
                </span>
            </div>

        </nav>

        <section class="main-section">

            <h3>Product Details</h3>
            <span class="addFile">
                Add Course
            </span>

            <?php
                if(isset($_SESSION['dash_msg'])){
                    $msg = $_SESSION['dash_msg'];
                    if($msg['status']){
                        echo '<span class="msg success">'.$msg['msg'].'</span>';
                    }
                    else{
                        echo '<span class="msg error">'.$msg['msg'].'</span>';
                    }
                    
                    unset($_SESSION['dash_msg']);
                }
            ?>

            <div class="table-section">
                <table>

                    <tr>
                        <th>Image</th>
                        <th>Course name</th>
                        <th>Price</th>
                        <th>Number of chapters</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                        if($courses):
                        foreach($courses as $course): 
                        $price = $course['price'] / 100;
                    ?>
                        <tr>
                            <td>
                                <img src="assets/images/course_images/<?= $course['pic']?>" alt="">
                            </td>
                            <td> <?= $course['pd_name']?> </td>
                            <td> $<?= $price?> </td>
                            <td> <?= $course['chapters']?> chapters</td>
                            <td> <?= $course['cat_name']?></td>
                            <td class="link">
                                <form action="" method="POST">
                                    
                                    <input type="submit" name="edit" value="Edit" data-courseID="<?=$course['pd_id']?>">
                                    
                                    <input type="submit" name="delete" value="Delete">
                                    <input type="hidden" name="hiddenID" value="<?=$course['pd_id']?>">

                                </form>
                            </td>     
                        </tr>
                    <?php endforeach;
                    endif; ?>

                </table>
            </div>

        </section>
    </main>

    <div class="modal">
        <div class="form-section">

            <div class="close-btn" title="close">
                <i class="fas fa-x"></i>
            </div>
            <img src="" alt="" id="img-preview">
            <form action="" method="POST" enctype="multipart/form-data">
                <h3>Enter Course Information</h3>

                <input type="hidden" id="hidden" name="option" value="add">

                <div class="input-part">
                    <div class="input">
                        <input type="text" id="cname" name="cname" required>
                        <label for="cname">Course name</label>
                    </div>

                    <div class="input">
                    <input type="number" id="price" name="price" required>
                    <label for="price">Price(in cents)</label>
                    </div>
                </div>
            
                <div class="input-part">
                    
                    <div class="input">
                        <input type="number" id="number" name="chapters" required>
                        <label for="number">Number of chapters</label>
                    </div> 

                    <fieldset>
                        <legend>Course Image</legend>
                        <input type="file" onchange="displayImage(this)" name="course_img" id="file" required>
                    </fieldset> 
                    
                    <div class="input">
                        <input type="text" id="cat" name="category" required>
                        <label for="cat">Category</label>
                    </div> 

                </div>

                <div class="textarea">
                    <textarea name="text" id="text" required></textarea>
                    <label for="text">Enter description here !!</label>

                </div>

                <input type="submit" name="add" value="Add" id="submit">
                
            </form>
        </div>
        
    </div>

    <script src="../assets/JS/imgPreview.js"></script>
    <script src="../assets/JS/dashboard.js"></script>

</body>
</html>
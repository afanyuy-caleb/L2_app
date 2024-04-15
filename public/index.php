<?php

    $route = explode('/', $_SERVER['REQUEST_URI'])[1];
    
    if($_SERVER['REQUEST_URI'] == "/" || $route == "index"){
        require_once '../views/index.php';
    }

    switch(True){

        case in_array($route, array("login","signin")):
            require_once '../views/auth/index.php';
            break;
        
        case in_array($route, array("register","signup", "registration")):
            require_once '../views/auth/registration.php';
            break;
        
        case in_array($route, array("dashboard", "admin", "dash")):
            require_once '../views/Home/dashboard.php';
            break;

        case in_array($route, array("homepage", "home")):
            require_once '../views/Home/homepage.php';
            break;
        
        case in_array($route, array("logout", "signout")):
            require_once '../views/Home/logout.php';
            break;
        
        case $route == "buy":
            require_once '../controllers/checkout.php';
            break;
        
        case in_array($route, array("checkout", "cart")):
            require_once '../views/Home/cart.php';
            break;
        
        default:
            require_once '../views/index.php';
            break;



    }


?>
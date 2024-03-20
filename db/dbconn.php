<?php

    $conn = new mysqli("localhost", "Keyz_dev", "cream", "shop");

    if(!$conn){
        die("connection error ". $conn->error);
    }

    return $conn;

?>
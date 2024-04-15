<?php
  session_start();

  function getCourse($id){
    foreach ($_SESSION['courses'] as $course){
      if($course['pd_id'] == $id){
        array_push($_SESSION['sel-prods'], $course);
        return;
      }
    }   
  }

  if(isset($_POST['selected_prod'])){
    
    $prod_id = $_POST['hidden'];
    // Verify if the item is already in the cart
    $bool = False;

    if(!empty($_SESSION['sel-prods'])){

      $courses = $_SESSION['sel-prods'];
      foreach($courses as $course){
        if($course['pd_id'] == $prod_id){
          $bool = true;
          $_SESSION['exist-msg'] = [
            "id" => $prod_id,
            "msg" => "Item already exists"
          ];

        }  
      }
      // If item doesn't exist,
      if(! $bool){
        getCourse($prod_id);

      }   
    }
    else{
      getCourse($prod_id);
      
    }  

    // Send back to homepage
    header("Location: /home");
    exit;
    
  }


?>
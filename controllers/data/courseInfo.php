<?php

    session_start();

    if($_REQUEST['id']){  
        $id = $_REQUEST['id'];
        if(isset($_SESSION['courses'])){
            
            $courses = $_SESSION['courses'];

            foreach($courses as $course){

                if($course['pd_id'] == $id){
                    print_r(json_encode($course));
                    exit();
                }
            }
        }
        else{
            echo null;
            exit();
        }
    }


?>
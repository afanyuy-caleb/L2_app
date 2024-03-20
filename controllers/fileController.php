<?php

session_start();

include_once '../controllers/regctrl.php';

class CourseManager extends RegisterUser{

    private $conn;
    function __construct()
    {
        $this->conn = require __DIR__ . "/../db/dbconn.php";
    }
    
    function addFile($elms, $files){
        $conn = $this->conn;

        $course_pic = $this->profilePicHandler($files, "products");
        $course_name = strtolower($elms['cname']);
        $course_desc = $elms['text'];
        $course_chap = $elms['chapters'];
        $course_price = $elms['price'];
        $category = strtolower($elms['category']);

        $catId = $this->checkCategory($category, "adding");

        try{
            
            $insert = "INSERT INTO courses(pd_name, description, pic, price, chapters, cat_id) VALUES(?, ?, ?, ?, ?, ?)";
        
            $stmt = $conn->prepare($insert);
    
            $array = array($course_name, $course_desc, $course_pic, $course_price, $course_chap, $catId);
    
            $stmt->execute($array);
            $this->successDisplay("inserted");

        }
        catch(mysqli_sql_exception $e){
            $this->errorDisplay("adding");
        } 
    }

    private function selectCatID($conn, $category){

        $sel = "SELECT cat_id FROM category where cat_name = '$category'";
        $que = $conn->query($sel);
        $result = $que->fetch_assoc();

        return $result['cat_id'];
    }
    function errorDisplay($type){
        $_SESSION['dash_msg'] = array( 
            'status' => false,
            'msg' => "Error {$type} course"
        );
        
        header("Location: ../views/Home/dashboard.php"); 
        exit();
    }

    function successDisplay($type){
        $_SESSION['dash_msg'] = array( 
            'status' => true,
            'msg' => "File {$type} successfully"
        );
        
        header("Location: ../views/Home/dashboard.php"); 
        exit();
    }

    function deleteFile($id){
        
        $conn = $this->conn;
        $del = "DELETE FROM courses WHERE pd_id = $id";
        $query = $conn->query($del);

        if(!$query){
            $this->errorDisplay("deleting");
        }

        $this->successDisplay("deleted");

    }
    
    function checkCategory($category, $type){
        $conn = $this->conn;
        $lists = $_SESSION['list'];

        try{
            
            foreach($lists as $list){
                if($list['cat_name'] === $category){
                    $catId = $list['cat_id'];
                }
            }
            if(!$catId){
                // insert the category into the category table
                $insert = "INSERT INTO category(cat_name) VALUE(?)";

                $stmt = $conn->prepare($insert);
                $array = array($category);
                $stmt->execute($array);

                $catId = $this->selectCatID($conn, $category);
            }

            return $catId;
        }catch(mysqli_sql_exception $e){
            $this->errorDisplay($type);
        }
    }

    function updateFile($elms, $files){
        $conn = $this->conn;

        $course_pic = $this->profilePicHandler($files, "products");
        $course_name = strtolower($elms['cname']);
        $course_desc = $elms['text'];
        $course_chap = $elms['chapters'];
        $course_price = $elms['price'];
        $category = strtolower($elms['category']);

        $catId = $this->checkCategory($category, "updating");

        try{
            $pdId = $elms['editId'];

            $update = "UPDATE courses set pd_name = ?, description = ?, pic = ?, price = ?, chapters = ?, cat_id = ? WHERE pd_id = ?";
        
            $stmt = $conn->prepare($update);
    
            $array = array($course_name, $course_desc, $course_pic, $course_price, $course_chap, $catId, $pdId);
    
            $stmt->execute($array);
            $this->successDisplay("updated");

        }
        catch(mysqli_sql_exception $e){
            $this->errorDisplay($conn->error);
        }    
    }
}

$course = new CourseManager;

if(isset($_POST['add']) && isset($_FILES['course_img']['name'])){

    if($_POST['option'] === "edit"){
        $course->updateFile($_POST, $_FILES['course_img']);

    }
    else{
        $course->addFile($_POST, $_FILES['course_img']);
    }

}
else if(isset($_POST['delete'])){
    $course->deleteFile($_POST['hiddenID']);

}
else{
    $course->errorDisplay("managing");
}
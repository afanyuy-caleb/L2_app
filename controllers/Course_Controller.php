<?php

$relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
array_pop($relative_dir);
$relative_dir = implode('\\', $relative_dir);

require_once $relative_dir . '\config\class_autoloader.inc.php';

class Course_Controller{

    private $conn, $course_obj, $pic_obj;
    function __construct()
    {   
        global $relative_dir;
        $this->conn = require $relative_dir . '\config\dbconn.php';
        $this->course_obj = new Courses();
        $this->pic_obj = new Register_Controller(null, null);
    }
    
    function addFile($elms, $files){

        $course_pic = $this->pic_obj->profilePicHandler($files, "products"); 
        $tmp_dir = $files['tmp_name'];

        $category = strtolower($elms['category']);
        $elms['cat_id'] = $this->checkCategory($category, "adding");
        $state = $this->course_obj->addCourse($elms, $course_pic);

        if($state){
            // Upload the image to the img_dir
            $targetDir =  "assets/images/course_images/{$course_pic}";
            move_uploaded_file($tmp_dir, $targetDir);

            $this->successDisplay("inserted");
        }
        else
            $this->errorDisplay("adding");
        
    }

    function getCourses($cond = null){

        $result = $this->course_obj->getCourse($cond);
        if(!$result)
            return null;
         
        if(!$cond)
            $_SESSION['courses'] = $result;
         
        return $result;
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
        
        header("Location: /dashboard"); 
        exit();
    }

    function successDisplay($type){
        $_SESSION['dash_msg'] = array( 
            'status' => true,
            'msg' => "File {$type} successfully"
        );
        
        header("Location: /dashboard"); 
        exit();
    }
    
    function checkCategory($category, $type){
        $conn = $this->conn;
        $lists = $_SESSION['list'];
        $catId = null;

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

        $course_pic = $this->pic_obj->profilePicHandler($files, "products");
        $tmp_dir = $files['tmp_name'];

        $category = strtolower($elms['category']);
        $elms['cat_id'] = $this->checkCategory($category, "updating");

        $state = $this->course_obj->update_Course($elms, $course_pic);
        if($state){
            // Upload the image to the img_dir
            $targetDir =  "assets/images/course_images/{$course_pic}";
            move_uploaded_file($tmp_dir, $targetDir);
            $this->successDisplay("updated");
        }
        else
            $this->errorDisplay("updating");
    }

    function deleteFile($id){

        $query = $this->course_obj->delete_Course($id);

        if(!$query){
            $this->errorDisplay("deleting");
        }

        $this->successDisplay("deleted");

    }
}

<?php
  $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
  array_pop($relative_dir);
  $relative_dir = implode('\\', $relative_dir);

  class Courses{
    private $table_name = 'courses', $conn;
    
    function __construct()
    {
      global $relative_dir;
      $this->conn = require $relative_dir . '\config\dbconn.php';
    }

    function addCourse($elms, $course_pic){

        $course_name = strtolower($elms['cname']);
        $course_desc = $elms['text'];
        $course_chap = $elms['chapters'];
        $course_price = $elms['price'];
        $catId = $elms['cat_id'];

        try{
            
          $insert = "INSERT INTO {$this->table_name}(pd_name, description, pic, price, chapters, cat_id) VALUES(?, ?, ?, ?, ?, ?)";
      
          $stmt = $this->conn->prepare($insert);
  
          $array = array($course_name, $course_desc, $course_pic, $course_price, $course_chap, $catId);
  
          $stmt->execute($array);
          return True;
      }
      catch(mysqli_sql_exception $e){
          return False;
      }       

    }

    function getCourse($cond = null){

      if($cond){
        $select = "SELECT * FROM {$this->table_name} WHERE {$cond}";

      }
      else{
        $select = "SELECT * FROM {$this->table_name} AS cs INNER JOIN categories AS ct
        ON cs.cat_id = ct.cat_id
        ";
      }

      $result = $this->conn->query($select);

      return $result->fetch_all(MYSQLI_ASSOC);
    }

    function update_Course($elms, $course_pic){
      $course_name = strtolower($elms['cname']);
      $course_desc = $elms['text'];
      $course_chap = $elms['chapters'];
      $course_price = $elms['price'];
      $catId = $elms['cat_id'];

      try{
        $pdId = $elms['editId'];

        $update = "UPDATE courses set pd_name = ?, description = ?, pic = ?, price = ?, chapters = ?, cat_id = ? WHERE pd_id = ?";
    
        $stmt = $this->conn->prepare($update);

        $array = array($course_name, $course_desc, $course_pic, $course_price, $course_chap, $catId, $pdId);

        $stmt->execute($array);

        return True;   

      }
      catch(mysqli_sql_exception $e){
        return False;
      }    
    }

    function delete_Course($id=null){

      $conn = $this->conn;
      if($id){
        $del = "DELETE FROM courses WHERE pd_id = $id";
        $query = $conn->query($del);
      }

      else{
        $del = "DELETE FROM courses";
        $query = $conn->query($del); 
      }

      if(!$query)
        return False;

      return True;
    }
  }



?>
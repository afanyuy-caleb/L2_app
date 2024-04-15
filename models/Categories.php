<?php

  class Categories{
    private $table_name = 'categories', $conn;
    
    function __construct()
    {
      $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
      array_pop($relative_dir);
      $relative_dir = implode('\\', $relative_dir);

      $this->conn = require $relative_dir . '\config\dbconn.php';
    }

    function addCategory($name){
     

    }

    function getCategory(){

      $select = "SELECT * FROM {$this->table_name}";
      $result = $this->conn->query($select);

      return $result->fetch_all(MYSQLI_ASSOC);
    }

    function update_Category(){

    }

    function delete_Category(){

    }
  }



?>
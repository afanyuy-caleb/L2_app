<?php
    $conn = require __DIR__ . '/../db/dbconn.php';

    function selectProducts(){
        global $conn;

        $select = "SELECT * FROM courses AS cs INNER JOIN category AS ct
        ON cs.cat_id = ct.cat_id
        ";
        $result = $conn->query($select);

        $result = $result->fetch_all(MYSQLI_ASSOC);
        if(!$result){
            return null;
        }
        
        return $result;
    }

    function selectCategories(){
        global $conn;

        $select = "SELECT * FROM category";
        $query = $conn->query($select);

        $result = $query->fetch_all(MYSQLI_ASSOC);
        if(!$result){
            return null;
        }

        return $result;
    }

?>
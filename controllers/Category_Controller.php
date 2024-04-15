<?php

    $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($relative_dir);
    $relative_dir = implode('\\', $relative_dir);

    include_once $relative_dir . '\models\Categories.php';

    class Category_Controller{

        function getCategories(){
            global $path_to_db;
    
            $cat = new Categories();        
            return $cat->getCategory() ?? NULL;
    
        }
    }


?>
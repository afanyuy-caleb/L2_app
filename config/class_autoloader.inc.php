<?php

    spl_autoload_register('my_custom_autoloader');

    function my_custom_autoloader($className){
        global $relative_dir;

        $dirs = array($relative_dir . '\\models\\', $relative_dir . '\\controllers\\');
        $extension = '.php';

        $bool = False;
        foreach($dirs as $dir){ 
            $file = $dir.$className.$extension;
            if(file_exists($file)){

                $bool = True;
                require_once $file;
            }
        }

        if(! $bool)
            die($file);

    }
    
?>
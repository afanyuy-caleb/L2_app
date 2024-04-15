<?php

    $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($relative_dir);
    $relative_dir = implode('\\', $relative_dir);

    require_once $relative_dir . '\config\class_autoloader.inc.php';

    class Register_Controller{

        private $postArray, $userObj,  $prof_pic = null, $path, $tmp_dir;

        // Class constructor

        function __construct($postArray, $setPicture){
            global $relative_dir;

            $this->path = $relative_dir;

            if($postArray){
                $this->userObj = new User();
                $this->dataVerification($postArray);
                $this->postArray = $postArray;
    
                if($setPicture){
                    $this->prof_pic = $this->profilePicHandler($setPicture, "user");
    
                }
            }
            
        }
        
        // Submitted data verification

        private function dataVerification($array){

            $nameErr = $this->nameVerify($array['username']);

            $emailErr = $this->emailVerify($array['email']);

            $passErr = $this->passVerify($array['pass'], $array['cpass']);
            
            if(!$nameErr || !$emailErr || !$passErr){

                header("Location: /registration");
                exit();
            }     
            
        }

        // Username conformity verification

        private function nameVerify($name){

            if(empty($name) || !filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS)){
                $_SESSION['name_err'] = "Incorrect name format";
                return false;
            }

            return true;
        }

        // email conformity verification

        private function emailVerify($email){
            if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION['email_err'] = "invalid email address";
                return false;

            }
            return true;
        }

        // password conformity verification

        private function passVerify($pass, $cpass){

            if(strlen($pass) < 5){
                $_SESSION['pass_err'] = "must be atleast 5 characters long";
                return false;

            }
            if(!preg_match('/[a-z]/i', $pass)){
                $_SESSION['pass_err'] = "must contain atleast a character";
                return false;
            }
            if(!preg_match('/[0-9]/', $pass)){
                $_SESSION['pass_err'] = "must contain atleast a digit";
                return false;
            }
            if($pass !== $cpass){
                $_SESSION['cpass_err'] = "passwords donot match";
                return false;
            }

            return true;
        }

        // Profile pic handler

        public function profilePicHandler($setPicture, $table){

            $ext = $this->profilePicVerify($setPicture);

            if( !$ext){
                if($table === "user"){

                    header("Location: /registration");
                }
                else{
                    $_SESSION['dash_msg'] = array( 
                        'status' => false,
                        'msg' => $_SESSION['pic_err']
                    );
                    header("Location: /dashboard");
                }
                exit();
                
            }

            // I need the length of the lone name, inorder to produce a new name of atmost 3 xters
            $len = strlen($ext[1]);
            $name = ($len > 2)? substr($ext[1], 0, 2): $ext[1];
            $name = $this->renameFile($ext[0], $name, $table);

            $this->tmp_dir = $setPicture['tmp_name'];
            return $name;
            
        }

        // Picture conformity checks

        function profilePicVerify($picArray){
    
            $name = $picArray['name'];
            $ext = $this->checkExtension($name);

            if( !$ext){
                $_SESSION['pic_err'] = "Invalid file extension";
                return false;
            }

            if( !$this->checkSize($picArray['size'] )){
                $_SESSION['pic_err'] = "File too large";
                return false;
            }

            return $ext;
        }

        // picture extension checks

        public function checkExtension($name){
            $extensions = ['png', 'jpg', 'avif', 'jpeg', 'svg', 'webp', 'gif', 'bmp', 'ico', 'tif', 'tiff'];

            $name = explode('.', $name);
            $ext = strtolower(end($name));

            if(! in_array($ext, $extensions)){
                return false;      
            }

            return [$ext, $name[0]];
        }

        // picture size checking

        public function checkSize($size){
            if($size > 1000000){
                return false;
            }

            return true;
        }

        // rename the profile pic from file

        public function renameFile($fileExt, $xters, $table){

            $id = 1;
            if($table === "user"){
                $oldId =  $this->path . "\models\storage\id.txt";
            }else{
                $oldId =  $this->path . "\models\storage\course_id.txt";
            }   

            if(file_exists($oldId)){
                $fp = fopen($oldId, 'r');
                $id = fgets($fp);
                $id ++;
            }

            $new_name = $xters.$id.'.'.$fileExt;

            $fp = fopen($oldId, 'w');
            fwrite($fp, $id);
            fclose($fp);

            return $new_name;
        }
        
        // Register the user now

        public function insertUser(){
            
            $state = $this->userObj->addUser($this->postArray, $this->prof_pic);
            if($state){

                // Upload the image to the img_dir
                $targetDir = "assets/images/profile-pics/{$this->prof_pic}";
                move_uploaded_file($this->tmp_dir, $targetDir);

                header("Location: /login");
                exit();
            }
            else{
                header("Location: /registration");
                exit();
            }
                        
        }
    }  

?>
<?php

    session_start();

    class RegisterUser{

        private $name, $email, $pass, $dob, $prof_pic = null, $conn;

        // Class constructor

        function __construct($postArray, $setPicture){

            $this->dataVerification($postArray);

            $this->conn = require __DIR__ . "/../db/dbconn.php";

            $this->name = $postArray['username'];
            $this->email = $postArray['email'];
            $this->pass = $postArray['pass'];
            $this->pass = password_hash($this->pass, PASSWORD_BCRYPT);
            $this->dob = $postArray['dob'];

            if($setPicture){
                $this->prof_pic = $this->profilePicHandler($setPicture, "user");

            }
        }
        
        // Submitted data verification

        private function dataVerification($array){

            $nameErr = $this->nameVerify($array['username']);

            $emailErr = $this->emailVerify($array['email']);

            $passErr = $this->passVerify($array['pass'], $array['cpass']);
            
            if(!$nameErr || !$emailErr || !$passErr){

                header("Location: ../views/auth/registration.php");
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

                    header("Location: ../views/auth/registration.php");
                }
                else{
                    $_SESSION['dash_msg'] = array( 
                        'status' => false,
                        'msg' => $_SESSION['pic_err']
                    );
                    header("Location: ../views/Home/dashboard.php");
                }
                exit();
                
            }

            // I need the length of the lone name, inorder to produce a new name of atmost 3 xters
            $len = strlen($ext[1]);
            $name = ($len > 2)? substr($ext[1], 0, 2): $ext[1];
            $name = $this->renameFile($ext[0], $name, $table);

            $tmp = $setPicture['tmp_name'];
            if($table === "user"){
                $targetDir = "../views/assets/images/profile-pics/{$name}";
            }
            else{
                $targetDir = "../views/assets/images/course_images/{$name}";
            }
            
            move_uploaded_file($tmp, $targetDir);

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
                $oldId = "../storage/id.txt";
            }else{
                $oldId = "../storage/course_id.txt";
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

        public function InsertUser(){

            try{
                $insert = "INSERT INTO users(name, email, passhash, DOB, profile_pic, role_id) VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $this->conn->prepare($insert);
    
                $stmt->bind_param("sssssi", $this->name, $this->email, $this->pass, $this->dob, $this->prof_pic, 2);

                $stmt->execute();
    
                $_SESSION['msg'] = [true, "Registration Successful"];
                header("Location: ../views/auth/index.php");
                exit();
                
            }
            catch(mysqli_sql_exception $e){
                $array = explode(" ", $this->conn->error);

                if(strpos(end($array), "email")){
                    $_SESSION['email_err'] = "email address already taken";
                }else{
                    $_SESSION['reg_failed'] = end($array);
                }
                
                header("Location: ../views/auth/registration.php");
                exit();
                
            }
            finally{
                $this->conn->close();
            }            
        }
    }

    // Instantiate an object

    if(isset($_POST['register'])){
        if($_FILES['prof-pic']['error'] != 0){

            $user = new RegisterUser($_POST, false);
        }
        else{
            
            $user = new RegisterUser($_POST, $_FILES['prof-pic']);
        }
    
        $user->InsertUser();    

    }

    


?>
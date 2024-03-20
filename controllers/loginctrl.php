<?php

    session_start();

    class User{
        private $email, $pass, $setCookie = false, $conn;

        function __construct($postArray){

            if(!filter_var($postArray['email'], FILTER_VALIDATE_EMAIL)){
                $this->errorMsg();
                exit();
            }
            $this->conn = require __DIR__ . "/../db/dbconn.php";

            $this->email = mysqli_real_escape_string($this->conn, $postArray['email']);
            $this->pass = $postArray['pass'];

            if($postArray['remember']){          
                $this->setCookie = true;
            }
        }

        public function login(){
            
            $select = "SELECT * FROM users WHERE email = '$this->email'";
            $query = $this->conn->query($select);
            $result = $query->fetch_assoc();
            
            if(!$result){
                $this->errorMsg();
                exit();
            }

            $this->conn->close();

            if(password_verify($this->pass, $result['passhash'])){

                if($this->setCookie){
                    setcookie('email', $this->email, time()+60*30*5);
                    setcookie('pass', $this->pass, time()+60*30*5);

                }

                unset($result['passhash']);
                $_SESSION['userInfo'] = $result;
                header("Location: ../views/Home/dashboard.php");

                exit();
            }
            else{

                $this->errorMsg();
                exit();
            }
        }

        private function errorMsg(){

            $_SESSION['msg'] = [false, "Incorrect email or password"];
            header("Location: ../views/auth/index.php");

            exit();
        }
    }

    $user = new User($_POST);

    $user->login();
    
?>
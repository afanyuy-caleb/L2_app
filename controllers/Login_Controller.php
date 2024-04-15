<?php
    $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
    array_pop($relative_dir);
    $relative_dir = implode('\\', $relative_dir);

    require_once $relative_dir . '\config\class_autoloader.inc.php';


    class Login_Controller{
        private $email, $pass, $userObj, $path, $setCookie = false;

        function __construct($postArray){

            $this->userObj = new User();

            if(!filter_var($postArray['email'], FILTER_VALIDATE_EMAIL)){
                $this->errorMsg();
            }

            $this->email = $postArray['email'];
            $this->pass = $postArray['pass'];

            if(isset($postArray['remember'])){          
                $this->setCookie = true;
            }
        }

        public function login(){    

            $result = $this->userObj->getUser($this->email);
            
            if(!$result){
                $this->errorMsg();
            }

            if(password_verify($this->pass, $result['passhash'])){

                if($this->setCookie){
                    setcookie('email', $this->email, time()+60*30*5);
                    setcookie('pass', $this->pass, time()+60*30*5);
                }

                unset($result['passhash']);
                $_SESSION['userInfo'] = $result;
                $_SESSION['sel-prods'] = array();

                if($result['role_id'] == 1){
                    header("Location: /dashboard");
                    exit();
                }
                else{}{
                    header("Location: /homepage");
                    exit();
                }
            }
            else{
                $this->errorMsg();
            }
        }

        private function errorMsg(){

            $_SESSION['msg'] = [false, "Incorrect email or password"];
            header("Location: /login");
            exit();
        }
    }

?>
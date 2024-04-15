<?php 

  class User{

    private $conn;
    private $tableName = 'users';

    function __construct()
    {
      $relative_dir = explode('\\', $_SERVER['DOCUMENT_ROOT']);
      array_pop($relative_dir);
      $relative_dir = implode('\\', $relative_dir);

      $this->conn = require $relative_dir . "\config\dbconn.php";
    }

    public function addUser($postArray, $profile_pic){

      extract($postArray);

      $pass = password_hash($pass, PASSWORD_BCRYPT);
      $prof_pic = $profile_pic ?? 'default.jpg';

      try{
        
        $insert = "INSERT INTO {$this->tableName}(name, email, passhash, DOB, profile_pic) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($insert);
        $array = array($username, $email, $pass, $dob, $prof_pic);
        $stmt->execute($array);

        $_SESSION['msg'] = [True, 'Registration successful'];

        return True;        
      }

      catch(\mysqli_sql_exception $e){

        $array = explode(" ", $this->conn->error);

        if(strpos(end($array), "email")){
            $_SESSION['email_err'] = "email address already taken";
        }else{

            $_SESSION['reg_failed'] = $this->conn->error;
        }
        
        return False;         
      }

      finally{
          $this->conn->close();
      }   
    }

    function getUser($email = null){
      
      if($email){
        $email = mysqli_real_escape_string($this->conn, $email);

        $select = "SELECT * FROM users WHERE email = '$email'";
        $query = $this->conn->query($select);
        
        return $query->fetch_assoc() ?? NULL;
      }
      else{
        $select = "SELECT * FROM users";
        $query = $this->conn->query($select);
        
        return $query->fetch_all(MYSQLI_ASSOC) ?? NULL;
      }

    }

    function update_User(){

    }

    function delete_User(){

    }

  }

?>
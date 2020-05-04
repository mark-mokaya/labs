<?php
include "crud.php";
include "authenticator.php";

class User implements Crud{
    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;

    private $username;
    private $password;

    //constructor to initiate member values (private - can't be initiated elsewhere)

    public function __construct($first_name, $last_name, $city_name, $username, $password){
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->city_name = $city_name;
        $this->username = $username;
        $this->password = $password;
    }

    //Multiple constructors not allowed, so we fake one. Using static and the create() method, we access the "fake constructor" with the class, not the object. 

    //Static constructor

    public static function create() {
        $instance = new self();
        return $instance;
    }

    //username setter
    public function setUsername($username){
        $this->username = $username;
    }

    //username getter
    public function getUsername(){
        return $this->username;
    }

    //password setter
    public function setPassword($password){
        $this->password = $password;
    }

    //password getter
    public function getPassword(){
        return $this->password;
    }

    //user_id setter
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    //user-id getter
    public function getUserId(){
        return $this->$user_id;
    }

    //check if user exists
    public function isUserExist(){
        //connect to database
        $con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $uname = $this->username;

        $res = mysqli_query($con, "SELECT username FROM user WHERE username = '$uname'") or die("Error " . mysqli_error($con));

        if(mysqli_num_rows($res)>0){
           return "Username already taken.";
        }else{
            return null;
        }
    }

    /* Defining all methods implemented from Crud */
    public function save(){
        //connect to database
        $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
     
        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;
        $uname = $this->username;
        $this->hashPassword();
        $pass = $this->password;

        $res = mysqli_query($conn, "INSERT INTO user (first_name, last_name, user_city, username, password)
        VALUES ('$fn', '$ln', '$city', '$uname', '$pass')") or die("Error " . mysqli_error($conn));

        mysqli_close($conn);
        return $res;

    }

    public function readAll(){ return null;}

    public function readUnique(){ return null;}

    public function search(){ return null;}

    public function update(){ return null;}

    public function removeOne(){ return null;}

    public function removeAll(){ return null;}

    public function validateForm(){ 
        // return true if values are not empty
        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;

        if($fn == "" || $ln == "" || $city == ""){
            return false;
        }
        return true;
    }

    public function createFormErrorSessions(){ 
        session_start();
        $_SESSION['form_errors'] = "All fields are required";
    }

    public function hashPassword(){ 
        //use password_hash() to hash password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function isPasswordCorrect(){
        //connect to database
        $con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        $found = false;
        $res = mysqli_query($con, "SELECT * FROM user") or die("Error " . mysqli_error($con));

        while ($row=mysqli_fetch_assoc($res)) {
            if(password_verify($this->getPassword(), $row['password']) && $this->getUsername() == $row['username']) {
                $found = true;
            }
        }

        //close database connection
        mysqli_close($con);
        return $found;
    }

    public function login(){
        if($this->isPasswordCorrect()){
            header("Location:private_page.php");
        }
    }

    public function createUserSession(){
        session_start();
        $_SESSION['username'] = $this->getUsername();
    }

    public function logout(){
        session_start();
        unset($_SESSION['username']);
        session_destroy();
        header("Location:lab1.php");
    }

}

?>
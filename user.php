<?php
include "crud.php";

class User implements Crud{
    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;

    //constructor to initiate member values (private - can't be initiated elsewhere)

    public function __construct($first_name, $last_name, $city_name){
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->city_name = $city_name;
    }

    //user_id setter
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    //user-id getter
    public function getUserId(){
        return $this->$user_id;
    }

    /* Defining all methods implemented from Crud */
    public function save(){
        //connect to database
        $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;

        $res = mysqli_query($conn, "INSERT INTO user(first_name, last_name, user_city) VALUES('$fn', '$ln', '$city')") or die("Error " . mysqli_error($conn));
        return $res;

    }

    public function readAll(){ return null;}
    public function readUnique(){ return null;}
    public function search(){ return null;}
    public function update(){ return null;}
    public function removeOne(){ return null;}
    public function removeAll(){ return null;}

}

?>
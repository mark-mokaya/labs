<?php

include_once '../../../DBConnector.php';
class ApiHandler{
    private $meal_name;
    private $meal_units;
    private $unit_price;
    private $status;
    private $user_api_key;

    // getters and setters

    public function setMealName($meal_name){
        $this->meal_name = $meal_name;
    }

    public function getMealName(){
        return $this->meal_name;
    }

    public function setMealUnits($meal_units){
        $this->meal_units = $meal_units;
    }

    public function getMealUnits(){
        return $this->meal_units;
    }

    public function setUnitPrice($unit_price){
        $this->unit_price = $unit_price;
    }

    public function getUnitPrice(){
        return $this->unit_price;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setUserApiKey($key){
        $this->user_api_key = $key;
    }

    public function getUserApiKey(){
        return $this->user_api_key;
    }

    public function createOrder(){
        // saving incoming order
        $con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $res = mysqli_query($con, "INSERT INTO orders (order_name, units, unit_price, order_status) VALUES ('$this->meal_name', '$this->meal_units', '$this->unit_price', '$this->status')") or die("Error " . mysqli_error($con));
        return $res;
    }

    public function checkOrderStatus($order_id){
        // retrieve order status
        $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        $res = mysqli_query($con->conn, "SELECT * FROM orders WHERE order_id = '$order_id'") or die("Error " . mysqli_error($con));

        $row=mysqli_fetch_assoc($res);
        return $row['order_status'];
    }

    public function fetchAllOrders(){

    }

    public function checkApiKey(){
        $currentApiKey = $this->user_api_key;

        $con = new DBConnector();
        $res = mysqli_query($con, "SELECT * FROM api_keys WHERE api_key = '$currentApiKey'") or die("Error " . mysqli_error($con));

        if(mysqli_num_rows($res)>0){
            return true;
         }else{
            return false;
         }
    }

    public function checkContentType(){

    }

    // plus many other functions according to the API features



}





?>
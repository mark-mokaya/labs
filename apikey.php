<?php
include_once 'DBConnector.php';

session_start();

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('HTTP/1.0 403 Forbidden');
        die('You are forbidden!');

    }else{
        $api_key = null;
        $api_key = generateApiKey(64);
        header('Content-type: application/json');
        echo generateResponse($api_key);
    }

/*
    this is how we generate a key. But you can device your own method 
    the parameter str_length determines the length of the key you want.
    In our case we have chosen 64 characters
*/

function generateApiKey($str_length){
    //base 62 map
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //get enough random bits for base 64 encoding (and prevent '=' padding)
    //note: +1 is faster than ceil()
    $bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);

    //convert base 64 to base 62 by mapping + and / to something from the base 62 map
    //use the first 2 random bytes for the characters
    $repl = unpack('C2', $bytes);

    $first = $chars[$repl[1]%62];
    $second = $chars[$repl[2]%62];
    return strtr(substr(base64_encode($bytes), 0, $str_length), '+/', "$first$second");

}

function saveApiKey($api_key){
    /* Write the code that will save the api key for the user
    this function returns true if the key is saved, false otherwise */

    //connect to database
    $con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }


    $user_id = $_SESSION['username'];

    $checkExistingAPIKey = mysqli_query($con, "SELECT * FROM api_keys WHERE user_id = '$user_id'") or die("Error " . mysqli_error($con));

    if(mysqli_num_rows($checkExistingAPIKey)>0){
        $res = mysqli_query($con, "UPDATE api_keys SET api_key = '$api_key' WHERE user_id = '$user_id'
        ") or die("Error " . mysqli_error($con));
        mysqli_close($con);       
    }else{
        $res = mysqli_query($con, "INSERT INTO api_keys (user_id, api_key)
        VALUES ('$user_id', '$api_key')") or die("Error " . mysqli_error($con));
        mysqli_close($con);
    }   

    if($res){
        return true;
    }else{
        return false;
    }
    
}

function generateResponse($api_key){
    if(saveApiKey($api_key)){
        $res = ['success' => 1, 'message' => $api_key];
    }else{
        $res = ['success' => 0, 'message' => 'Something went wrong. Please regenerate the API key'];
    }
    return json_encode($res);
}

?>
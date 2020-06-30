<?php
include_once 'DBConnector.php';

session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}

echo $_SESSION['username'];

function fetchUserApiKey(){   
    $user_id = $_SESSION['username'];

    $con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);  
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  
    $res = mysqli_query($con, "SELECT * FROM api_keys WHERE user_id = '$user_id'") or die("Error " . mysqli_error($con));

    if(mysqli_num_rows($res)>0){
        if ($row=mysqli_fetch_assoc($res)) {
            return $row['api_key'];
        }
    }
}

?>

<html>
    <head>
        <script src="jquery-3.5.1.js"></script>
        <script type="text/javascript" src="validate.js"></script>
        <script type="text/javascript" src="apikey.js"></script>

        <title>Title goes here</title>
        <link rel="stylesheet" type="text/css" href="main.css">

        <!-- Bootstrap file-->
        <!-- js -->

        <script type="text/javascript" src="bootstrap\js\bootstrap.js"></script>
        <script type="text/javascript" src="bootstrap\js\bootstrap.min.js"></script>

        <!-- css -->
        <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css.map">
        
   
    </head>

    <body style="margin-left:50px;">
    
        <p align='right'><a href="logout.php">Logout</a></p>
        <hr>
        <h3>Here, we will create an API that will allow Users/Developer to order items from external systems</h3>
        <hr>
        <h4> We now put this feature of allowing users to generate an API key. Click the button to generate the API key</h4>

        <button class="btn btn-primary" id="api-key-btn" >Generate API key</button> <br> <br>

        <!-- This text are will hold the API key -->
        <strong> Your API key: </strong> (Note that if your API key is already in use by already running applications, generating a new key will stop the application from functioning)<br>

        <textarea cols="100" row="2" id="api_key" name="api_key" readonly><?php echo fetchUserApiKey();?></textarea>

        <h3>Service description</h3>
        We have a service/API that allows external applications to order food and also pull all order status by using order id. Let's do it.

        <hr>

    </body>
</html>
<?php
    //login code
    include_once 'DBConnector.php';
    include_once 'user.php';

    $con = new DBConnector; //connect to database
    if(isset($_POST['btn-login'])){
        $first_name = null;
        $last_name = null;
        $city = null;
        $username = $_POST['username'];
        $password = $_POST['password'];

        // not working for some reason
        // $instance = User::create();
        // $instance->setPassword($password);
        // $instance->setUsername($username);

        $instance = new User($first_name, $last_name, $city, $username, $password);

        if($instance->isPasswordCorrect()){
            $instance->login();
            //close database connection
            $con->closeDatabase();
            //create user session
            $instance->createUserSession();
        }else{
            $con->closeDatabase();
            header["Location:login.php"];
        }

    }

?>

<html>
    <head>
        <title>Title goes here</title>
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <!-- $_SERVER['PHP_SELF'] submits form to itself for processing-->

        <form method="post" name="login" id="login" action="<?=$_SERVER['PHP_SELF'];?>">
        
            <table align="center">
                <tr>
                    <td><input type="text" name="username" placeholder="Username" required></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td><button type="submit" name="btn-login"><strong>LOGIN</strong></button></td>
                </tr>
            </table>
               
        </form>
    </body>
</html>
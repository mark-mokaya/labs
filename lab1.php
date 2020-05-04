<?php
    include_once 'DBConnector.php';
    include_once 'user.php';
    $con = new DBConnector; //database connection

    if(isset($_POST['btn-save'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $city = $_POST['city_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];


        //Create user object, constructor will initialize vaiables
        $user = new User($first_name, $last_name, $city, $username, $password);

        //check if username is available
        $availabilityCheck = $user->isUserExist();

        if(!isset($availabilityCheck)){
            $res = $user->save();
                //check if save is successful
            if($res){
                echo "Save operation was successful";
            }else{
                echo "An error occured";
            }
        }

    }
?>
<html>
    <head>
        <title>Title goes here</title>
        <link rel="stylesheet" type="text/css" href=
        "main.css">

        <script type="text/javascript" src="validate.js"></script>
    </head>
    <body>
        <form method="post" name="user_details" id="user_details" onsubmit="return validateForm()" action="<?php $_SERVER['PHP_SELF'];?>">
            <table align="center">
                <tr>
                    <td>
                        <div id="form-errors">
                            <?php
                                session_start();
                                if(isset($availabilityCheck)){
                                    $_SESSION['form_errors'] = $availabilityCheck;
                                    $availabilityCheck = null;
                                }

                                if(!empty($_SESSION['form_errors'])) {
                                    echo " " . $_SESSION['form_errors'];
                                    unset($_SESSION['form_errors']);
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="first_name" required placeholder="First Name"></td>
                </tr>
                <tr>
                    <td><input type="text" name="last_name" placeholder="Last Name"></td>
                </tr>
                <tr>
                    <td><input type="text" name="city_name" placeholder="City"></td>
                </tr>
                <tr>
                    <td><input type="text" name="username" required placeholder="Username"></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" required placeholder="Password"></td>
                </tr>
                <tr>
                    <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
                </tr>
                <tr>
                    <td><a href="login.php">Login</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>
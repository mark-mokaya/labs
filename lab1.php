<?php
    include_once 'DBConnector.php';
    include_once 'user.php';
    include_once 'fileUploader.php';
    $con = new DBConnector; //database connection

    if(isset($_POST['btn-save'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $city = $_POST['city_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $utc_timestamp = $_POST['utc_timestamp'];
        $offset = $_POST['time_zone_offset'];


        //Create user object, constructor will initialize vaiables
        $user = new User($first_name, $last_name, $city, $username, $password, $utc_timestamp, $offset);

        //create object for file uploading
        $uploader = new FileUploader;

        //check if username is available
        $availabilityCheck = $user->isUserExist();

        if(!isset($availabilityCheck)){
            // call uploadFile() function which returns
            $file_upload_response = $uploader->fileWasSelected($_FILES["fileToUpload"]);

            //return file properties for validation
            $fileExistsCheck = $uploader->fileAlreadyExists();
            $fileTypeCheck = $uploader->fileTypeIsCorrect();
            $fileSizeCheck = $uploader->getFileSize();
            
            if(!$fileExistsCheck && $fileTypeCheck && $fileSizeCheck<50000){
                $res = $user->save();
                $file_upload_response = $uploader->uploadFile($username);

                //check if save is successful
                if($res && $file_upload_response){
                    echo "Save operation was successful";
                }else{
                    echo "An error occured";
                }
            }            
        }

        

    }
?>
<html>
    <head>
        <title>Title goes here</title>
        <link rel="stylesheet" type="text/css" href=
        "main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="validate.js"></script>
        <script src="timezone.js"></script>
    </head>
    <body>
        <form method="post" enctype="multipart/form-data" name="user_details" id="user_details" onsubmit="return validateForm()" action="<?php $_SERVER['PHP_SELF'];?>">
            <table align="center">
                <tr>
                    <td>
                        <div id="form-errors">
                            <?php
                                session_start();
                            
                                if(isset($availabilityCheck)){
                                    $_SESSION['form_errors'] = $availabilityCheck;
                                    $availabilityCheck = null;
                                }elseif(isset($fileExistsCheck) && $fileExistsCheck){
                                    $_SESSION['form_errors'] = "Uploaded file already exists";
                                    $fileExistsCheck = null;
                                }elseif(isset($fileTypeCheck) && !$fileTypeCheck){
                                    $_SESSION['form_errors'] = "Uploaded file is not an image";
                                    $fileTypeCheck = null;
                                }elseif(isset($fileSizeCheck) && $fileSizeCheck>50000){
                                    $_SESSION['form_errors'] = "Uploaded file is too big";
                                    $fileSizeCheck = null;
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
                    <td>Profile image: <input type="file" name="fileToUpload" id="fileToUpload"></td>
                </tr>
                <tr>
                    <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
                </tr>

                <input type="hidden" name="utc_timestamp" id="utc_timestamp" value="">

                <input type="hidden" name="time_zone_offset" id="time_zone_offset" value="">

                <tr>
                    <td><a href="login.php">Login</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>
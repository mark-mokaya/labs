<?php

class FileUploader{
    //member variables
    private static $target_directory = "uploads/";
    private static $size_limit = 5000; //size given in bytes
    private $uploadOk = false;
    private $file_original_name;
    private $file_type;
    private $file_size;
    private $final_file_name;

    //getters and setters
    public function setOriginalName($name){
        $this->file_original_name = $name;
    }

    public function getOriginalName(){
        return $this->file_original_name;
    }

    public function setFileType($type){
        $this->file_type = $type;
    }

    public function getFileType(){
        return $this->file_type;
    }

    public function setFileSize($size){
        $this->file_size = $size;
    }

    public function getFileSize(){
        return $this->file_size;
    }

    public function setFinalFileName($final_name){
        $this->final_file_name = $final_name;
    }

    public function getFinalFileName(){
        return $this->final_file_name;
    }

    //methods
    
    public function uploadFile($username){

        $con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $file_name = $this->getOriginalName();
        $final_file_name = $this->getFinalFileName();
        $file_type = $this->getFileType();
        $file_size = $this->getFileSize();
        
        if($this->uploadOk){
            move_uploaded_file($file_name, self::$target_directory . basename($final_file_name));
            mysqli_query($con, "UPDATE user SET profile_image='$final_file_name' WHERE username= '$username'") or die("Error " . mysqli_error($con));
            mysqli_close($con);
            return true;
        }else{
            return false;
        }

    }

    public function fileAlreadyExists(){
        $file_name = self::$target_directory . basename($this->getFinalFileName());
        if(file_exists($file_name)){
            return true;
        }else{
            return false;
        }
    }

    public function saveFilePathTo(){}
    public function moveFile(){}

    public function fileTypeIsCorrect(){
        $file_type = $this->getFileType();
        if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif"){
            return false;
        }else{
            return true;
        }
    }

    public function fileWasSelected($fileUploaded){
        $file_name = $this->setOriginalName($fileUploaded["tmp_name"]);

        $rinal_file_name = $this->setFinalFileName($fileUploaded["name"]);
        
        $file_type = $this->setFileType(strtolower(pathinfo($this->getFinalFileName(), PATHINFO_EXTENSION)));

        $file_size = $this->setFileSize($fileUploaded['size']);

        if(!$this->fileAlreadyExists($file_name) && $this->fileTypeIsCorrect($file_type) && $file_size < 50000){
            $this->uploadOk = true;
        } else{
            $this->uploadOk = false;
        }

    }








}
?>
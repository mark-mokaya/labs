<?php
    define('DB_SERVER', 'localhost'); //we use the local machine
    define('DB_USER', 'root'); //user is root
    define('DB_PASS', ''); //not set
    define('DB_NAME', 'btc3205'); //database name

    class DBConnector{
        public $conn;

        /* connect to database in constructor, to happen whenever object is created*/

        function __construct() {
            $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        }

        public function closeDatabase(){
            mysqli_close($conn);
        }
    }
?>
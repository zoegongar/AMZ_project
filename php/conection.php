<?php

require_once 'query.php';

class Connection {

    public static function getConnection() {

        $servername = "localhost";
        $database = 'amz';
        $username = "root";
        $password = "rootroot";

        $conn = mysqli_connect($servername, $username, $password, $database); 

        Connection::checkConection($conn);

        return $conn;
    }
        
    // Compruebo la conexión a la bbdd
    private static function checkConection($conn){
        if (!$conn) {
            error_log("Error connecting with database: " . mysqli_connect_error());
        } 	
    }

}

?>
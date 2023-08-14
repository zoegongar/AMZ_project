<?php
//Declaramos y asignamos variables.



// Creamos la conexión
function getConnection() {

    $servername = "localhost";
    $database = 'amz';
    $username = "root";
    $password = "rootroot";

	$conn = mysqli_connect($servername, $username, $password, $database); 

    check_conection($conn);

    return $conn;
}
    
// Compruebo la conexión a la bbdd
function check_conection($conn){
    if (!$conn) {
        echo("error");
        echo("Algo ha ido mal: " . mysqli_connect_error());
    } else {
        echo ("Estamos en conexión. <br>"); 
    }	
}
?>
<?php
//lea la cookie
// Supongamos que tienes una cookie llamada "miCookie"

function read_cookie(){
    if(isset($_COOKIE["session_id"])) {
        $valorCookie = $_COOKIE["session_id"];
        echo "El valor de la cookie es: " . $valorCookie;
    } else {
        echo "La cookie no está seteada.";
    }
}
//se conecte a la base de datos y comprube que la session si la sessión devuelve false manda 
//al inicio de session.
//Las otras páginas llaman a la función que comprueba si la sesión es ok o no.
// Llamámos a la función que crea la conexión

function check_cookie(){
    $id_session = "";
    if(isset($_COOKIE["session_id"])) {
        $id_session = $_COOKIE["session_id"];
        echo "El valor de la cookie es: " . $id_session;
    } else {
        echo "La cookie no está seteada.";
    }

    $conn = getConnection();
    $cookie_count = cookie_count($id_session);
    echo "<h1><marquee>$cookie_count</marquee></h1>";
    $result_cookie_count = $conn->query($cookie_count);
    $row = $result_cookie_count->fetch_assoc();
    $session_count = $row['session_count'];


    if ($session_count === 0) {
        if ($shift_count == 0) {
            header("Location: login.php");
        } else {
                echo "Ya hay permanencia en esas horas.";
        }
    }    
}

?>
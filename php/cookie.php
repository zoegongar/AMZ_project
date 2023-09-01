<?php
//lea la cookie
// Supongamos que tienes una cookie llamada "miCookie"

class Cookies {

    public static function read_cookie(){
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
    public static function check_cookie(){

        $id_session = "";

        if(isset($_COOKIE["session_id"])) {
            $id_session = $_COOKIE["session_id"];
            echo "El valor de la cookie es: " . $id_session;
        } else {
            echo "La cookie no está seteada.";
        }

        $conn = Connection::getConnection();
        $cookie_count = Queries::cookie_count();

        $stmt = $conn->prepare($cookie_count);
        $stmt->bind_param("s", $id_session);
        $stmt->execute();
        $stmt->bind_result($result_cookie_count);
        $stmt->fetch();
        $stmt->close();

        $session_count = $result_cookie_count; 

        if ($session_count === 0) {
            if ($shift_count == 0) {
                header("Location: login.php");
            } else {
                echo "Ya hay permanencia en esas horas.";
            }
        }

    }

}

?>
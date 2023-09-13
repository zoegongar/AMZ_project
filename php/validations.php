<?php

class Validations {

    public static function check_form($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $pass) {

        $result = "";


        if (empty($user_type)) {
            $result = $result . "<li>error tipo de usuaria</li>";
        }

        if (empty($name) || is_numeric($name)) {
            $result = $result . "<li>error nombre</li>";
        } 

        if (empty($surname_1) || is_numeric($surname_1)) {
            $result = $result . "<li>error apellido</li>";
        }

        if (empty($surname_2) || is_numeric($surname_2)) {
            $result = $result . "<li>error apellido</li>";
        }

        if (empty($dni)) {
            $result = $result . "<li>error dni</li>";
        } else if (check_dni($dni) === false) {
            $result = $result . "<li>error dni</li>";			
        }

        if (empty($telephone)) {
            $result = $result . "<li>error teléfono</li>";
        }

        if (empty($pass)) {
            $result = $result . "<li>error contraseña</li>";
        }


        if (strlen($result) > 0) {
            $result = "<ul>$result</ul>";
        }

        return $result;
    }

}

?>
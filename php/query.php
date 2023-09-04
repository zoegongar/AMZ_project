<?php

class Queries {

    //Crea usuaria
    public static function add_user() {
        return "INSERT INTO users (id_type_user, name, surname_1, surname_2, dni, telephone, pass) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    //Buscar usuaria
    public static function query_search_user($dni){
        return "SELECT * FROM users WHERE dni='$dni'";
    }

    //devuelve el tipo de usuaria
    public static function query_id_type_user() {
        return "SELECT id_type_user from users where id= ?";
    }

    //Modificar usuaria
    public static function query_update_user( $user_type, $name, $surname_1, $surname_2, $dni, $telephone){
        return "UPDATE  users SET id_type_user = '$user_type', name = '$name', surname_1 = '$surname_1', surname_2 = '$surname_2', telephone = '$telephone' WHERE dni = '$dni' ";
    }

    //Borra usuaria
    public static function query_delete_user($id_user) {        
        return "DELETE FROM users where id=$id_user";
    }

    //crear nueva permanencia
    public static function query_add_shift(){
        return "INSERT INTO shift (start_day, week_day, start_time, end_time) VALUES (?, ?, ?, ?)";       
    }

    public static function query_add_shift_user() {
        return "INSERT INTO shift_user(id_user, id_shift) values (?, ?)";

    }

    //Modificar permanencia
    public static function query_update_shift(){
        return "UPDATE  shift SET start_day = ?, week_day = ?, start_time = ?, end_time = ?, end_day = ? WHERE id = ?";
    }

    //Borra permanencia
    public static function query_delete_shift($id_shift) {        
        return "DELETE FROM shift where id=$id_shift";
    }

    public static function query_number_user_shift ($start_day, $start_time, $end_time) {
        return "SELECT start_day, start_time, end_time, COUNT(*) AS cantidad
        FROM shift
        WHERE start_day = '$start_day'
        and start_time = '$start_time'
        and end_time = '$end_time'
        GROUP BY start_day, start_time, end_time
        HAVING COUNT(*) > 1;";
    }

    // comprueba la password
    public static function check_pass() {
        return "SELECT pass FROM users WHERE dni = ?";
    }

    public static function get_user_id() {
        return "SELECT id FROM users WHERE dni = ?";
    }
    
    //comprueba el estado y de session y tipo de usuaria que esta en la session
    public static function check_session($id_session) {
        return "SELECT COUNT(*) as id_session FROM session WHERE  id_session='$id_session' AND end_session=null";
    }

    // Generar una id aleatoria e insertarla en la bbdd
    public static function add_session($session_id, $id_user) {
        return "INSERT INTO session (id_session, id_user, start_session) VALUES ('$session_id', '$id_user', now())";
    }

    //comprobar si la cookie está activa
    public static function cookie_count() {
        return "SELECT COUNT(*) as session_count FROM session WHERE id_session = ? AND end_session is null";
    }    

    //inserta la hora del fin de session
    public static function end_session($id_session, $end_session) {
        return "UPDATE session set end_session = '$end_session' where id_session = '$id_session'";
    }

    public static function thing() {
        return "SELECT COUNT(*) as shift_count FROM shift WHERE week_day = ? AND start_time <= ? AND end_time >= ?";
    }

    public static function get_shifts() {
        return "SELECT id_shift as 'Numero permanencia', week_day as 'Dia de la semana', start_day as 'Dia de inicio', start_time as 'Hora de inicio', end_time as 'Hora de fin', id_user as 'Id de usuario' FROM shift";
    }

}

?>
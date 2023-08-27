<?php
    //Crea usuaria
    function add_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $password_hash) {
        return "INSERT INTO users (id_type_user, name, surname_1, surname_2, dni, telephone, pass) VALUES ('$user_type', '$name', '$surname_1', '$surname_2', '$dni', '$telephone', '$password_hash')";
    }

    //Buscar usuaria
    function query_search_user($id_user){
        return "SELECT * FROM users WHERE id='$id_user'";
    }

    //devuelve el tipo de usuaria
    function query_id_type_user($id_user) {
        return "SELECT id_type_user from users where id='$id_user'";
    }

    //Modificar usuaria
    function query_update_user($id_user, $user_type, $name, $surname_1, $surname_2, $dni, $telephone){
        return "UPDATE  users SET id_type_user = '$user_type', name = '$name', surname_1 = '$surname_1', surname_2 = '$surname_2', dni = '$dni', telephone = '$telephone' WHERE id = $id_user";
    }

    //Borra usuaria
    function query_delete_user($id_user) {        
        return "DELETE FROM users where id=$id_user";
    }

    //crear nueva permanencia
    function query_add_shift($id_shift, $start_day, $day_week, $start_time, $end_time, $id_user){
		return "INSERT INTO shift (id, start_day, week_day, start_time, end_time) VALUES ('$id_shift', '$start_day', $day_week, '$start_time', '$end_time')";       
	}

    //Modificar permanencia
    function query_update_shift($id_shift, $start_day, $day_week, $start_time, $end_time){
        return "UPDATE  shift SET start_day = '$start_day', week_day = '$day_week', start_time = '$start_time', end_time = '$end_time' WHERE id = '$id_shift'";
    }

    //Añadir usuaria a una permanencia
    function query_add_user_shift($id_shift, $id_user){
        return "INSERT INTO shift_user (id_shift, id_user) VALUES ($id_shift, $id_user)";
    }

    //añade id_shift y id_user a la tabla shift_user
    function query_add_shift_user($conn, $id_new_shift, $id_user) { 
    $select_last_id = "SELECT max(id) as id_number FROM AMZ.shift";
    $result_last_id = $conn->query($select_last_id);                  
        if ($result_last_id->num_rows > 0) {
            $row = $result_last_id->fetch_assoc();
            $id_new_shift = $row["id_number"];
        } else {
            $id_new_shift = 0; // Manejar el caso de que no haya registros
        }
        return "INSERT INTO shift_user (id_shift, id_user) VALUES ('$id_new_shift', '$id_user')";
    }
    
    //Borra permanencia
    function query_delete_shift($id_shift) {        
        return "DELETE FROM shift where id=$id_shift";
    }

    function query_number_user_shift ($start_day, $start_time, $end_time) {
        return "SELECT start_day, start_time, end_time, COUNT(*) AS cantidad
        FROM shift
        WHERE start_day = '$start_day'
        and start_time = '$start_time'
        and end_time = '$end_time'
        GROUP BY start_day, start_time, end_time
        HAVING COUNT(*) > 1;";
    }

    // comprueba la password
    function check_pass() {
        return "SELECT pass FROM users WHERE id = ?";
    }
    
    //comprueba el estado y de session y tipo de usuaria que esta en la session
    function check_session($id_session) {
        return "SELECT COUNT(*) as id_session FROM session WHERE  id_session='$id_session' AND end_session=null";
    }

    // Generar una id aleatoria e insertarla en la bbdd
    function add_session($session_id, $id_user) {
        return "INSERT INTO session (id_session, id_user, start_session) VALUES ('$session_id', '$id_user', now())";
    }

    //comprobar si la cookie está activa
    function cookie_count($id_session) {
        return "SELECT COUNT(*) as session_count FROM session WHERE id_session = '$id_session' AND end_session is null";
    }    

    //inserta la hora del fin de session
    function end_session($id_session, $end_session) {
        return "UPDATE session set end_session = '$end_session' where id_session = '$id_session'";
    }
?>
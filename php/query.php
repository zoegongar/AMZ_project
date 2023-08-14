<?php
    //Crea usuaria
    function add_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone) {
       
        return "INSERT INTO users (id_type_user, name, surname_1, surname_2, dni, telephone) VALUES ('$user_type', '$name', '$surname_1', '$surname_2', '$dni', '$telephone')";
        
    }

    //Buscar usuaria
    function search_user($id_user){
        return "SELECT * FROM users WHERE id='$id_user'";
    }

    //Modificar usuaria
    function update_user($id_user, $user_type, $name, $surname_1, $surname_2, $dni, $telephone){
        return "UPDATE  users SET id_type_user = '$user_type', name = '$name', surname_1 = '$surname_1', surname_2 = '$surname_2', dni = '$dni', telephone = '$telephone' WHERE id = $id_user";
    }

    //Borra usuaria
    function delete_user($id_user) {
        
        return "DELETE FROM users where id=$id_user";
    }

    //crear nueva permanencia
    function add_period($start_day, $start_time, $end_time, $id_user){
		return "INSERT INTO period (start_day, start_time, end_time) VALUES ('$start_day', '$start_time', '$end_time')";
        
	}

    //Modificar permanencia
    function update_period($id_user, $user_type, $name, $surname_1, $surname_2, $dni, $telephone){
        return "UPDATE  users SET id_type_user = '$user_type', name = '$name', surname_1 = '$surname_1', surname_2 = '$surname_2', dni = '$dni', telephone = '$telephone' WHERE id = $id_user";
    }

    //añade id_period y id_user a la tabla period_user
    function create_period_user($id_period, $id_user) {
        echo("colega");
        return "INSERT INTO period_user (id_period, id_user) VALUES ('$id_period', '$id_user')";
    }


    //Borra permanencia
    function delete_period($id_period) {
        
        return "DELETE FROM period where id=$id_period";
    }



?>
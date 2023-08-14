<?php
    //Crea usuaria
    function add_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone) {
       
        return "INSERT INTO users (id_type_user, name, surname_1, surname_2, dni, telephone) VALUES ('$user_type', '$name', '$surname_1', '$surname_2', '$dni', '$telephone')";
        
    }

    //Borra usuaria
    function delete_user($id_user) {
        
        return "DELETE FROM users where id=$id_user";
    }

    //crear nueva permanencia
    function add_period($start_day, $start_time, $end_time){
		return "INSERT INTO period (start_day, start_time, end_time) VALUES ('$start_day', '$start_time', '$end_time')";
	}


?>
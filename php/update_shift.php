<?php
require 'conection.php'; 
require 'query.php';

if (isset($_POST['submit']))  {

	// Llamámos a la función que crea la conexión
	$conn = getConnection();
	
	//asigna a las variables $nombre $apellido_1... el valor que recoge de  'name'.   
	$start_day = filter_input(INPUT_POST, 'start_day');
	$week_day = filter_input(INPUT_POST, 'week_day');
	$start_time = filter_input(INPUT_POST, 'start_time');	
	$end_time = filter_input(INPUT_POST, 'end_time');	
	$id_user =filter_input(INPUT_POST, 'id_user');	
	$id_shift =filter_input(INPUT_POST, 'id_shift');	
	
	$today = today();
	$day_week = get_Week_day($start_day);
	// Consulta SQL para verificar si hay un evento en el rango de tiempo dado
	$check_shift = "SELECT COUNT(*) as shift_count FROM shift WHERE week_day = '$day_week' AND start_time <= '$start_time' AND end_time >= '$end_time'";
	$result_check_shift = $conn->query($check_shift);
	$time_duration = check_shift_duration($start_time, $end_time);
	$check_form_result = check_form($start_day, $time_duration);	
		
	if($start_day > $today) {
		if (strlen($check_form_result) === 0) {
			$row = $result_check_shift->fetch_assoc();
			$shift_count = $row['shift_count'];
			if ($shift_count == 1) {
				echo("entró en el contador.");

					//Introduzco nueva permanencia en la base de datos
					update_shift($conn,$id_shift, $start_day, $day_week, $start_time, $end_time, $id_user);
					// Insertar el último ID en otra tabla
					//$new_shift_user = query_add_shift_user($conn, $id_new_shift, $id_user);
					echo "<h1>consulta: $shift_count</h1>";
					
				
			} else {
				echo "<p>$check_form_result</p>";
				echo "Error en la consult: " . $conn->error;
			}

			mysqli_close($conn);
		} else {
			echo "$check_form_result";
		}
	} else {
		echo ("No puedes crear una permanencia con una fecha anterior a hoy. ");
	}		
}

function get_Week_day($start_day) {
	return date('w', strtotime($start_day));
}

function today() {
	return date('Y-m-d');
}

echo "<h1>dia $week_day</h1>";
	
/*function new_shift_user($conn, $id_new_shift, $id_user){
	echo "<h1>update shift</h1>";
	$AMZ = query_add_shift_user($conn, $id_new_shift, $id_user);		
} */

function update_shift($connection, $id_shift, $start_day, $day_week, $start_time, $end_time) {
	echo "<h1>update</h1>";
	$AMZ = query_update_shift($id_shift, $start_day, $day_week, $start_time, $end_time);
	echo "<p>$AMZ</p>";
	if ($connection->query($AMZ) === TRUE) {
		//$id_shift = $connection->insert_id; // Get the auto-incremental ID
		//return $id_shift;
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		return -1;
	}
}

function get_users_in_shift($connection, $user_in_shift, $start_day, $start_time, $end_time) {
	$user_in_shift = query_number_user_shift ($start_day, $start_time, $end_time);
	$result = mysqli_query($connection, $user_in_shift);
	$row = mysqli_fetch_assoc($result);
	if ($row) {
		return $row['cantidad']; 
	} else {
		return 0;
	}
}	

function check_form($start_day, $time_duration) {
	$result = "";
		
	echo "<h1>checking $start_day</h1>";
				
	if ($time_duration < 2) {
		$result = $result . "<li>Entre la hora de inicio y la hora de fin no pasan más de dos horas. </li>";
	} 
		
	if (strlen($result) > 0) {
		$result = "<ul>$result</ul>";
	}

	return $result;	
}

function check_shift_duration($start_time, $end_time) {
	// Convertir las horas de entrada en formato Unix
	$start_time_seconds = strtotime($start_time);
	$end_time_seconds = strtotime($end_time);
	// Sacamos la duración de la permanencia en segundos y después lo pasamos a horas.
	$seconds_duration = $end_time_seconds - $start_time_seconds;
	$time_duration = $seconds_duration / 3600; // 3600 segundos en una hora
	echo("el tiempo de duración es de $time_duration horas. <br>");

	return $time_duration;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar permanencia</title>
</head>
<body>
<div>
<p><a href="new_shift.php">new shift</a></p>
<p><a href="update_shift.php">update shift</a></p>
<p><a href="delete_shift.php">delete shift</a></p>
<p><a href="new_user.php">new user</a></p>
<p><a href="update_user.php">update user</a></p>
<p><a href="delete_user.php">delete user</a></p>
<p><a href="shift_table.php">tabla de permanencias</a></p>
</div>
<div>
<p class="title">Modificar permanencia</p>
<form action="update_shift.php" method="POST"> 
Número de permanencia <input type="number" name="id_shift">
Dia comienzo <input type="date" name="start_day" required>  
Hora comienzo <input type="time" name="start_time" >
hora fin <input type="time" name="end_time" ><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>
<h1>patata</h1>
</form>
<p>
</div>
</body>

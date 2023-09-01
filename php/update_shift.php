<?php
require_once 'conection.php'; 
require_once 'query.php';
include_once 'navigator_var.php';


if (isset($_POST['submit']))  {

	// Llamámos a la función que crea la conexión
	$conn = Connection::getConnection();
	
	//asigna a las variables $nombre $apellido_1... el valor que recoge de  'name'.   
	$start_day = filter_input(INPUT_POST, 'start_day');
	$week_day = filter_input(INPUT_POST, 'week_day');
	$start_time = filter_input(INPUT_POST, 'start_time');	
	$end_time = filter_input(INPUT_POST, 'end_time');	
	$id_user =filter_input(INPUT_POST, 'id_user');	
	$id_shift =filter_input(INPUT_POST, 'id_shift');	
	$end_day = filter_input(INPUT_POST, 'end_day');	
	$today = today();
	$day_week = get_Week_day($start_day);
	// Consulta SQL para verificar si hay un evento en el rango de tiempo dado
	$time_duration = check_shift_duration($start_time, $end_time);
	$check_form_result = check_form($start_day, $time_duration);	
		
	if($start_day > $today) {

		if (strlen($check_form_result) === 0) {

			$check_shift_result = checkShift($conn, $day_week, $start_time, $end_time, $start_day, $id_shift, $end_day);
			echo "<h1>$check_shift_result</h1>";
			if ( $check_shift_result === 0) {
				echo("entró en el contador.");

				
					//Introduzco nueva permanencia en la base de datos
					update_shift($conn, $id_shift, $start_day, $day_week, $start_time, $end_time, $end_day);
					// Insertar el último ID en otra tabla
					//$new_shift_user = query_add_shift_user($conn, $id_new_shift, $id_user);
					
				
			// } else {
			// 	echo "<p>$check_form_result</p>";
			// 	echo "Error en la consult: " . $conn->error;
			// }

			mysqli_close($conn);
			}
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
	
/*function new_shift_user($conn, $id_new_shift, $id_user){
	echo "<h1>update shift</h1>";
	$AMZ = query_add_shift_user($conn, $id_new_shift, $id_user);		
} */

function update_shift($connection, $id_shift, $start_day, $day_week, $start_time, $end_time, $end_day) {
	echo "<h1>update</h1>";
	echo "<h1>$end_day</h1>";

	$sql = Queries::query_update_shift();
	$stmt = $connection->prepare($sql);

	echo "$start_day, $day_week, $start_time, $end_time, $end_day, $id_shift, $end_day";

	//return "UPDATE  shift SET start_day = ?, week_day = ?, start_time = ?, end_time = ?, end_day = ? WHERE id_shift = ?";

	$stmt->bind_param("sissss", $start_day, $day_week, $start_time, $end_time, $end_day, $id_shift);
	
	if ($stmt->execute()) {
		return 1; // Get the auto-incremental ID
	} else {
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

function checkShift($conn, $day_week, $start_time, $end_time, $start_day, $id_shift, $end_day) {
    $check_shift = "SELECT COUNT(*) as shift_count FROM shift WHERE week_day = ? AND start_time <= ? AND end_time >= ? AND (start_day <= ? AND (end_day IS NULL or end_day >= ?)) AND id_shift != ?";
    
    $stmt = $conn->prepare($check_shift);
    $stmt->bind_param("sssssi", $day_week, $start_time, $end_time, $end_day, $start_day, $id_shift);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $shift_count = $row['shift_count'];
    
    $stmt->close();
    
    return $shift_count;
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
//Muestra la tabla de permanencias.
function getShifts() {
	$conn = Connection::getConnection();
	$query = "SELECT id_shift as 'Numero permanencia', week_day as 'Dia de la semana', start_day as 'Dia de inicio', end_day as 'Dia de fin', start_time as 'Hora de inicio', end_time as 'Hora de fin', id_user as 'Id de usuario' FROM shift"; //Queries::get_shifts();
	$result = $conn->query($query);

	$table =  "<table border='1'>
	<tr>
		<th>Numero permanencia</th>
		<th>Dia de la semana</th>
		<th>Dia de inicio</th>
		<th>Dia de fin</th>
		<th>Hora de inicio</th>
		<th>Hora de fin</th>
		<th>Id de usuario</th>
	</tr>";

	while($row = $result->fetch_assoc()) {
        $table = $table . "<tr>
                <td>".$row["Numero permanencia"]."</td>
                <td>".$row["Dia de la semana"]."</td>
                <td>".$row["Dia de inicio"]."</td>
                <td>".$row["Dia de fin"]."</td>
                <td>".$row["Hora de inicio"]."</td>
                <td>".$row["Hora de fin"]."</td>
                <td>".$row["Id de usuario"]."</td>
            </tr>";
    }

	$table = $table . "</table>";

	return $table;
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
<!-- <h1>Permanencias</h1> 
<div><?php // echo getShifts(); ?></div>-->

<div>
<p class="title">Modificar permanencia</p>
<form action="update_shift.php" method="POST"> 
Número de permanencia <input type="number" name="id_shift">
Dia comienzo <input type="date" name="start_day" required>  
Dia fin <input type="date" name="end_day">  

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

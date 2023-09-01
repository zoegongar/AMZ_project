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

	$today = today();
	$day_week = get_Week_day($start_day);
	// Consulta SQL para verificar si hay un evento en el rango de tiempo dado
	$time_duration = check_shift_duration($start_time, $end_time);
	$check_form_result = check_form($start_day, $time_duration);	
		
	if($start_day > $today) {
		if (strlen($check_form_result) === 0) {

			$shift_count = checkShift($conn, $day_week, $start_time, $end_time, $start_day);
			
			if ($shift_count > 0) {
				echo "Ya hay permanencia en esas horas.";
			} else {
				echo "No hay permanencias y se va a crear la tuya.";
				//Introduzco nueva permanencia en la base de datos
				$id_new_shift = create_shift($conn, $start_day, $day_week, $start_time, $end_time);
				if ($id_new_shift > -1) {
					$result = $associate_shift($conn, $id_user, $id_new_shift);
				}

				if ($result) {
					echo "<h1>Permanencia creada con éxito.</h1>";
				} else {
					echo "<h1>No se ha podido crear la permanencia.</h1>";
				}

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
	
function new_shift_user($conn, $id_new_shift, $id_user){
	echo "<h1>create shift</h1>";
	$AMZ = query_add_shift_user($conn, $id_new_shift, $id_user);		
} 

function create_shift($connection, $start_day, $day_week, $start_time, $end_time) {

	$sql = Queries::query_add_shift();
	$stmt = $connection->prepare($sql);
	$stmt->bind_param("siss", $start_day, $day_week, $start_time, $end_time);
	
	if ($stmt->execute()) {
		return $connection->insert_id; // Get the auto-incremental ID
	} else {
		return -1;
	}

}

function associate_shift($connection, $id_user, $id_new_shift) {

	$add_new_shift_user = Queries::query_add_shift_user();
	$stmt = $conn->prepare($add_new_shift_user);
	$stmt->bind_param("ii", $id_user, $id_new_shift);
	
	if ($stmt->execute()) {
		return true;
	} else {
		return false;
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

function checkShift($conn, $day_week, $start_time, $end_time, $start_day) {
    $check_shift = "SELECT COUNT(*) as shift_count FROM shift WHERE week_day = ? AND start_time <= ? AND end_time >= ? AND (start_day <= ? AND (end_day IS NULL or end_day >= ?))";
    
    $stmt = $conn->prepare($check_shift);
    $stmt->bind_param("sssss", $day_week, $start_time, $end_time, $start_day, $start_day);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $shift_count = $row['shift_count'];
    
    $stmt->close();
    
    return $shift_count;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nueva permanencia</title>
</head>
<body>
<div>
<p class="title">Nueva permanencia</p>
<form action="new_shift.php" method="POST"> 
Usuaria <input type="number" name="id_user">
Dia comienzo <input type="date" name="start_day" required>  
Hora comienzo <input type="time" name="start_time" >
hora fin <input type="time" name="end_time" ><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>
</form>
<p>
</div>
</body>


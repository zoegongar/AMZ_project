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
<?php 
	require 'conection.php'; 
	require 'query.php';
?>	
<div>
<p class="title">Nueva permanencia</p>
<form action="new_period.php" method="POST"> 
Usuaria <input type="number" name="id_user">
Dia comienzo <input type="date" name="start_day" required>  
Hora comienzo <input type="time" name="start_time" >
hora fin <input type="time" name="end_time" ><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>
<h1>patata</h1>
<?php


if (isset($_POST['submit']))  {

	// Llamámos a la función que crea la conexión
	$conn = getConnection();
	
	//asigna a las variables $nombre $apellido_1... el valor que recoge de  'name'.   
	$start_day = filter_input(INPUT_POST, 'start_day');
	$start_time = filter_input(INPUT_POST, 'start_time');	
	$end_time = filter_input(INPUT_POST, 'end_time');	
	$id_user =filter_input(INPUT_POST, 'id_user');	
	$id_period =filter_input(INPUT_POST, 'id_period');	
	//Introduzco nueva permanencia en la base de datos
	$AMZ = add_period($start_day, $start_time, $end_time, $id_user);

	if (mysqli_query($conn, $AMZ)) {
		if ($conn->query($AMZ) === TRUE) {
            $id_period = $conn->insert_id; // Get the auto-incremental ID
            echo "New record inserted successfully. Inserted ID is: " . $id_period;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

		create_period($start_day, $start_time, $end_time, $id_user);
		create_period_user($id_period, $id_user);
	} else {
		echo "Error: " . $AMZ . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);

	//Comprueba los errores, números en campos alfabéticos, campos vacíos...	
	if (empty($start_day) or empty($start_time) or empty($end_time)) 
	{
		campo_vacio();
	} 
}
	
	function campo_vacio() {
		echo("Los campos remarcados en rojo están rellenados de forma incorrecta. RECUERDA  <br>" );
			echo("Los campos obligatorios no puede estar vacios. <br>");
	}
	
	function create_period($start_day, $start_time, $end_time, $id_user){
		echo("Se ha creado correctamente la permancia para la usuaria $id_user del día $start_day de $start_time a $end_time. ");
	}
?>
</form>
<p>
</div>
</body>

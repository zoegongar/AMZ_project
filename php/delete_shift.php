<?php
require_once 'conection.php'; 
require_once 'query.php';
include_once 'navigator_var.php';

if (isset($_POST['submit']))  {

	//llama a la función que hace la conexión
	$conn = getConnection();
	
		//asigna a las variables $nombre $apellido_1... el valor que recoge de  'name'.   
	$id_shift = filter_input(INPUT_POST, 'id_shift');
	
	//Introduzco usuaria en la base de datos
	$AMZ = delete_shift($id_shift);

	if (mysqli_query($conn, $AMZ)) {
		erase_shift($id_shift);
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
	
	function erase_shift($id_shift){
		echo ("Has borrado la permanencia número $id_shift");
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrar permanencia</title>
</head>
<body>
<div>
<p><a href="check_time_shift.php">new shift</a></p>
<p><a href="update_shift.php">update shift</a></p>
<p><a href="delete_shift.php">delete shift</a></p>
<p><a href="new_user.php">new user</a></p>
<p><a href="update_user.php">update user</a></p>
<p><a href="delete_user.php">delete user</a></p>
<p><a href="shtift_table.php">tabla de permanencias</a></p>
</div>
<div>
<p class="title">Borrar permanencia</p>
<form action="delete_shift.php" method="POST"> 
Número de permanencia<input type="number" name="id_shift" required>  
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>
<h1>patata</h1>
</form>
<p>
</div>
</body>

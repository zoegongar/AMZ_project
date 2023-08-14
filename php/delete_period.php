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
<?php 
	require 'conection.php'; 
	require 'query.php';
?>	
<div>
<p class="title">Borrar permanencia</p>
<form action="delete_period.php" method="POST"> 
Número de permanencia<input type="number" name="id_period" required>  
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>
<h1>patata</h1>
<?php

if (isset($_POST['submit']))  {

	//llama a la función que hace la conexión
	$conn = getConnection();
	
		//asigna a las variables $nombre $apellido_1... el valor que recoge de  'name'.   
	$id_period = filter_input(INPUT_POST, 'id_period');
	
	//Introduzco usuaria en la base de datos
	$AMZ = delete_period($id_period);

	if (mysqli_query($conn, $AMZ)) {
		erase_period($id_period);
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
	
	function erase_period($id_period){
		echo ("Has borrado la permanencia número $id_period");
	}
?>
</form>
<p>
</div>
</body>

<?php
require_once 'conection.php'; 
require_once 'query.php';
include_once 'navigator_var.php';

if (isset($_POST['submit']))  {

	//llama a la función que hace la conexión
	$conn = connection::getConnection();
	
		//asigna a las variables $nombre $apellido_1... el valor que recoge de  'name'.   
	$id_shift = filter_input(INPUT_POST, 'id_shift');
	
	//Introduzco usuaria en la base de datos
	$AMZ = Queries::query_delete_shift($id_shift);

	if (mysqli_query($conn, $AMZ)) {
		erase_shift($id_shift);
	} else {
		echo "Error: " . $AMZ . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);

	  
}
	
	function campo_vacio() {
		echo("Los campos remarcados en rojo están rellenados de forma incorrecta. RECUERDA  <br>" );
			echo("Los campos obligatorios no puede estar vacios. <br>");
	}
	
	function erase_shift($id_shift){
		echo ("Has borrado la permanencia número $id_shift. ");
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

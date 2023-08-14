<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>borrar usuaria</title>
</head>
<body>
<?php 
	require 'conection.php'; 
	require 'query.php';
?>	
<div>
<p class="title">Borrar usuaria</p>
<form action="delete_user.php" method="POST"> 
Número usuaria <input type="number" name="id_user">  
<br>
<input type="submit" name="delete" value="delete">
<input type="reset" value="reset" name="borrar"><br><br>
<h1>chorizo</h1>
<?php

//asigna a las variables $name $surname_1... el valor que recoge de  'name'.   
	//$name = filter_input(INPUT_POST, 'name');
	$id_user = filter_input(INPUT_POST, 'id_user');
	

if (isset($_POST['delete']))  {

	//Declaramos y asignamos variables.
	$servername = "localhost";
	$database = 'amz';
	$username = "root";
	$password = "rootroot";

	//Comprueba los errores, números en campos alfabéticos, campos vacíos...	
	if (empty($id_user)) 
	{
		empty_space($id_user);
	} 
		else {
		echo("Datos correctos");
	}

	//llama a la función que hace la conexión
	$conn = getConnection();
	
	//llama a la función que borra la usuaria
	$AMZ = delete_user($id_user);

	if (mysqli_query($conn, $AMZ)) {
		//delete_user($name, $id_user);
	} else {
		echo "Error: " . $AMZ . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);	   
}
	
	function empty_space($id_user) {
		echo("Los campos remarcados en rojo están rellenados de forma incorrecta. RECUERDA<br>" );
		if (empty($id_user)){
			echo("La socia invisible no existe, prueba de nuevo.<br>");
		} 
	}
?>
</form>
<p>
</div>
</body>

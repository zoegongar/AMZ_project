<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nueva usuaria</title>
</head>
<body>
<?php 
	require 'conection.php'; 
	require 'query.php';
?>	
<div>
<p class="title">Nueva usuaria</p>
<form action="new_user.php" method="POST"> 
Tipo de usuaria <input type="number" name="user_type" require>  	
Nombre <input type="text" name="name" require>  
Primer apellido <input type="text" name="surname_1" >
Segundo apellido <input type="text" name="surname_2" ><br>
Numero de DNI <input type="text" name="dni">
Teléfono<input type="tel" name="telephone" pattern="[0-9]+" ><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>
<h1>patata</h1>
<?php


if (isset($_POST['submit']))  {

	//Declaramos y asignamos variables.


	//Comprueba los errores, números en campos alfabéticos, campos vacíos...	
	if (empty($name) or empty($surname_1) or empty($dni) or empty($telephone) or empty($user_type)) 
	{
		empty($name);
	} 
		elseif (is_numeric($name) or  is_numeric($surname_1) or is_numeric($surname_2)) {
		wrong_dates($name);
	}
		else {
		$name = new_user($name);
	}

	// Creamos la conexión
	
	// Compruebo la conexión a la bbdd
	//if (!$conn) {
	//	die("Algo ha ido mal: " . mysqli_connect_error());
	//} else {
	//	echo ("Estamos en conexión. <br>"); 
	//}	


	//asigna a las variables $name $surname_1... el valor que recoge de  'name'.   
	$name = filter_input(INPUT_POST, 'name');
	$surname_1 = filter_input(INPUT_POST, 'surname_1');	
	$surname_2 = filter_input(INPUT_POST, 'surname_2');	
	$dni = filter_input(INPUT_POST, 'dni');	
	$telephone = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
	$user_type = filter_input(INPUT_POST, 'user_type', FILTER_VALIDATE_INT);

	//Introduzco usuaria en la base de datos
	$AMZ = add_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone);

    $conn = getConnection();

	if (mysqli_query($conn, $AMZ)) {
		new_user($name);
	} else {
		echo "Error: " . $AMZ . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);

	//Comprueba los errores, números en campos alfabéticos, campos vacíos...	
	if (empty($name) or empty($surname_1) or empty($dni) or empty($telephone) or empty($user_type)) 
	{
		empty_space($name);
	} 
		elseif (is_numeric($name) or  is_numeric($surname_1) or is_numeric($surname_2)) {
		wrong_dates($name);
	}
		else {
		$name = new_user($name, $telephone);
	}   
}
	
	function empty_space($name) {
		echo("Los campos remarcados en rojo están rellenados de forma incorrecta. RECUERDA  <br>" );
		if (empty($name)){
			echo("Los campos obligatorios no puede estar vacios. <br>");
		} 
	}

	function wrong_dates($name) {	
		if (is_numeric($name))
		echo("Los campos remarcados en rojo están rellenados de forma incorrecta. RECUERDA  <br>" );
			echo("Los campos alfabéticos no pueden contener números<br>");
		}	
	
	
	function new_user($name){
		echo ("Has creado a la socia $name correctamente");
	}
?>
</form>
<p>
</div>
</body>

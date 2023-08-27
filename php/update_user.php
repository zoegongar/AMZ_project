<?php
require 'conection.php'; 
require 'query.php';
require 'cookie.php';

if (isset($_POST['submit']))  {

	

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

	//asigna a las variables $name $surname_1... el valor que recoge de  'name'.   
	$id_user = filter_input(INPUT_POST, 'id_user');
    $user_type = filter_input(INPUT_POST, 'user_type', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name');
	$surname_1 = filter_input(INPUT_POST, 'surname_1');	
	$surname_2 = filter_input(INPUT_POST, 'surname_2');	
	$dni = filter_input(INPUT_POST, 'dni');	
	$telephone = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
	
	//Cambio usuaria en la base de datos
	$AMZ = query_update_user($id_user, $user_type, $name, $surname_1, $surname_2, $dni, $telephone);
    echo $AMZ . "<br>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar usuaria</title>
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
<p class="title">Nueva usuaria</p>
<form action="update_user.php" method="POST"> 
Número usuaria <input type="number" name="id_user">    
Tipo de usuaria <input type="number" name="user_type" require>  	
Nombre <input type="text" name="name" require>  
Primer apellido <input type="text" name="surname_1" >
Segundo apellido <input type="text" name="surname_2" ><br>
Numero de DNI <input type="text" name="dni">
Teléfono<input type="tel" name="telephone" pattern="[0-9]+" ><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>

</form>
<p>
</div>
</body>

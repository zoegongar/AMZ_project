<?php
require_once 'conection.php'; 
require_once 'query.php';
require_once 'cookie.php';
include_once 'navigator_var.php';


if (isset($_POST['submit']))  {

	//asigna a las variables $name $surname_1... el valor que recoge de  'name'.   
	$dni = filter_input(INPUT_POST, 'dni');	
    $user_type = filter_input(INPUT_POST, 'user_type', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name');
	$surname_1 = filter_input(INPUT_POST, 'surname_1');	
	$surname_2 = filter_input(INPUT_POST, 'surname_2');	
	$telephone = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
	
	//Cambio usuaria en la base de datos
	$AMZ = Queries::query_update_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone);
    
    $conn = Connection::getConnection();

	if (mysqli_query($conn, $AMZ)) {

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
		$name = update_user($name, $telephone);
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
	
	
	function update_user($name){
		echo ("Has modificado a la socia $name correctamente");
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
<p class="title">Modificar usuaria</p>
<form action="update_user.php" method="POST"> 
Numero de DNI <input type="text" name="dni">
Tipo de usuaria <input list="user_type" name="user_type">
  <datalist id="user_type">
    <option value="1">Master
    <option value="2">Activo
    <option value="3">Itinerante
	<option value="4">Junior/Juvenil
	<option value="5">Afiliado
  </datalist><br>		
Nombre <input type="text" name="name" require>  
Primer apellido <input type="text" name="surname_1" >
Segundo apellido <input type="text" name="surname_2" ><br>
Teléfono<input type="tel" name="telephone" pattern="[0-9]+" ><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>

</form>
<p>
</div>
</body>

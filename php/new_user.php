<?php
require_once 'conection.php'; 
require_once 'query.php';
require_once 'check_data.php';
require_once 'cookie.php';
require_once 'validations.php';
require_once 'data_base.php';
include_once 'navigator_var.php';

Cookies::check_cookie();

if (isset($_POST['submit']))  {

	//Comprueba los errores, números en campos alfabéticos, campos vacíos...	

	//asigna a las variables $name $surname_1... el valor que recoge de  'name'.   
	
	$name = filter_input(INPUT_POST, 'name');
	$surname_1 = filter_input(INPUT_POST, 'surname_1');	
	$surname_2 = filter_input(INPUT_POST, 'surname_2');	
	$dni = filter_input(INPUT_POST, 'dni');	
	$telephone = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
	$user_type = filter_input(INPUT_POST, 'user_type', FILTER_VALIDATE_INT);
	$password = filter_input(INPUT_POST, 'pass');

	$check_form_result = Validations::check_form($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $password);

	if (strlen($check_form_result) === 0) {

		// Crear un hash de la contraseña
		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$query_add_user = Queries::add_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $password_hash);

		//Introduzco usuaria en la base de datos
		$conn = Connection::getConnection();
		$stmt = $conn->prepare($query_add_user);
		$stmt->bind_param("sssssss", $user_type, $name, $surname_1, $surname_2, $dni, $telephone, $password_hash);
		
		if ($stmt->execute()) {
			echo ("Has creado a la socia $name correctamente");
		} else {
			echo "Error:<br>" . mysqli_error($conn);
		}

		$stmt->close();
		$conn->close();

	} else {

		echo $check_form_result;

	}
}
	
?>
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
<div>
<p class="title">Nueva usuaria</p>
<form action="new_user.php" method="POST"> 
Tipo de usuaria <input type="number" name="user_type" require>  	
Nombre <input type="text" name="name" require>  
Primer apellido <input type="text" name="surname_1" >
Segundo apellido <input type="text" name="surname_2" ><br>
Numero de DNI <input type="text" name="dni">
Teléfono<input type="tel" name="telephone" pattern="[0-9]+" ><br>
Contraseña<input type="password" name="pass"><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>

</form>
<p>
</div>
</body>

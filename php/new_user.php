<?php
require 'conection.php'; 
require 'query.php';
require 'check_data.php';
require 'cookie.php';

check_cookie();
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

	// Crear un hash de la contraseña
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	$check_form_result = check_form($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $password_hash);
	
	if (strlen($check_form_result) === 0) {

	//Introduzco usuaria en la base de datos
		$AMZ = add_user($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $password_hash);

		$conn = getConnection();

		if (mysqli_query($conn, $AMZ)) {
			new_user($name);
		} else {
			echo "Error: " . $AMZ . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	} else {
		echo $check_form_result;
	}
}
	
	function new_user($name){
		echo ("Has creado a la socia $name correctamente");
	}

	function check_form($user_type, $name, $surname_1, $surname_2, $dni, $telephone, $pass) {
		$result = "";

		echo "<h1>checking $dni</h1>";

		if (empty($user_type)) {
			$result = $result . "<li>error user_type</li>";
		}

		if (empty($name) || is_numeric($name)) {
			$result = $result . "<li>error nombre</li>";
		} 

		if (empty($surname_1) || is_numeric($surname_1)) {
			$result = $result . "<li>error surname</li>";
		}

		if (empty($surname_2) || is_numeric($surname_2)) {
			$result = $result . "<li>error surname</li>";
		}

		if (empty($dni)) {
			$result = $result . "<li>error dni</li>";
		} else if (check_dni($dni) === false) {
				$result = $result . "<li>error dni</li>";			
		}

		if (empty($telephone)) {
			$result = $result . "<li>error telephone</li>";
		}

		if (empty($pass)) {
			$result = $result . "<li>error user_type</li>";
		}


		if (strlen($result) > 0) {
			$result = "<ul>$result</ul>";
		}
	
		return $result;
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
<p><a href="new_shift.php">new shift</a></p>
<p><a href="update_shift.php">update shift</a></p>
<p><a href="delete_shift.php">delete shift</a></p>
<p><a href="new_user.php">new user</a></p>
<p><a href="update_user.php">update user</a></p>
<p><a href="delete_user.php">delete user</a></p>
<p><a href="shtift_table.php">tabla de permanencias</a></p>
</div>
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

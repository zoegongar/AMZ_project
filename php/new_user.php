<?php
require_once 'conection.php'; 
require_once 'query.php';
require_once 'check_data.php';
require_once 'cookie.php';
require_once 'validations.php';
require_once 'data_base.php';
include_once 'navigator_var.php';
include_once '../html/form_new_user.html';

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

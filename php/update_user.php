<?php
require_once 'conection.php'; 
require_once 'query.php';
require_once 'cookie.php';
include_once 'navigator_var.php';
include_once '../html/form_update_user.html';


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


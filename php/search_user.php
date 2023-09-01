<?php
require_once 'conection.php'; 
require_once 'query.php';
include_once 'navigator_var.php';


//asigna a las variables $name $surname_1... el valor que recoge de  'name'.   
	//$name = filter_input(INPUT_POST, 'name');
	$dni = filter_input(INPUT_POST, 'dni');
	$name = filter_input(INPUT_POST, 'name');
	

if (isset($_POST['search']))  {

	//Comprueba los errores, números en campos alfabéticos, campos vacíos...	
	if (empty($dni)) 
	{
		empty_space($dni);
	} 
		else {
		echo("Datos correctos. ");
	}

	//llama a la función que hace la conexión
	$conn = Connection::getConnection();
	
	//llama a la función que borra la usuaria
	$AMZ = Queries::query_search_user($dni);

	$result = mysqli_query($conn, $AMZ);

	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($data as $row) {
		//echo implode($row);
		
        echo "DNI: " . $row['dni'] . "<br>";
		echo " TypeUser: " . $row['id_type_user'] . "<br>";
		echo " Name: " . $row['name'] . "<br>";
		echo " Surname: " . $row['surname_1'] . " " . $row['surname_2'] . "<br>";
		echo " Id usuaria: " .  $row['id'] . "<br>"; 
		echo " Telephone: " . $row['telephone'] . "<br>";		
    }


	/*if (mysqli_query($conn, $AMZ)) {
		//search_user($name, $id_user);
	} else {
		echo "Error: " . $AMZ . "<br>" . mysqli_error($conn);
	}*/

	mysqli_close($conn);	   
}
	
	function empty_space($id_user) {
		echo("Los campos remarcados en rojo están rellenados de forma incorrecta. RECUERDA<br>" );
		if (empty($id_user)){
			echo("La socia invisible no existe, prueba de nuevo.<br>");
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
    <title>borrar usuaria</title>
</head>
<body>
<div>
<p class="title">Buscar usuaria</p>
<form action="search_user.php" method="POST"> 
DNI usuaria <input type="varchar" name="dni">  
<br>
<input type="submit" name="search" value="search">
<input type="reset" value="reset" name="borrar"><br><br>
</form>
<p>
</div>
</body>

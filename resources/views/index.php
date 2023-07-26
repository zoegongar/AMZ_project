
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
<p class="title">Nueva usuaria</p>
<form action="index.php" method="POST">
Nombre <input type="text" name="name" require>  
Primer apellido <input type="text" name="apellido_1" require>
Segundo apellido <input type="text" name="apellido_2" require><br>
Numero de usuaria <input type="text" readonly>
Teléfono<input type="tel" name="telephone" pattern="[0-9]+" require><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="submit" value="reset" name="reset"><br><br>

<?php

	if (!isset($contact_list)) {
		$contact_list = [];
	}
	

	if (isset($_POST['submit'])){
			//asigna a la variable $name el valor que recoge de  'name'.   
			$name = filter_input(INPUT_POST, 'name');

			$telephone = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
		
			$contact_list = filter_input(INPUT_POST, "contact_list", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];
		if (empty($name) or is_numeric($name)) {
			nombre_invalido($name);
		} elseif (array_key_exists($name, $contact_list) && (empty($telephone))) {
			$contact_list = delete_contact($name, $contact_list);
		} else {
			$contact_list = create_modify_contact($contact_list, $name, $telephone);
		}   
	}
	
	if (isset($_POST['reset'])){
		unset($contact_list); 
		$contact_list = array(); 
	}	
	
	
	function nombre_invalido($name) {
		echo("El campo del nombre está relleno de forma incorrecta. RECUERDA  <br>" );
		if (is_numeric($name)){
			echo("El campo del nombre no puede contener números<br>");
		} else {
			echo("El campo del nombre no puede estar en vacio. <br>");
		}	
	}
	
	function create_modify_contact($contact_list, $name, $telephone){
		
		if (array_key_exists($name, $contact_list)){
			$contact_list [$name] = $telephone;
			echo("Acabas de modificar el contacto $name");

		}elseif (empty($telephone)) {
			echo("El teléfono está vacio. Si quieres borrar un contacto asegúrate de que el nombre está bien escrito. De lo contrario introduce un número.");
		}else {
			$contact_list [$name] = $telephone;				
			echo("Has creado un contacto nuevo");
		}
		
		return $contact_list;
	}
	
	function delete_contact($name, $contact_list){
		unset($contact_list[$name]);
		echo("Acabas de borrar el contacto $name.");
		return $contact_list;
	}

      	foreach($contact_list as $name =>$telephone){
        	echo ("<input type='hidden' name='contact_list[$name]' value = '$telephone' />\n");
      	}
	


?>
</form>
<p>
<?php

	        	
	foreach ($contact_list as $name =>$telephone){
		echo("Nombre: $name, Telefono: $telephone. <br>");
        }
	
?>

<div>
</body>

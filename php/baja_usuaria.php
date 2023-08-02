
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
Nombre <input type="text" name="name">
<input type="submit" name="buscar" value="buscar"><br>
Numero de DNI <input type="text" pattern="[0-9]+">
<input type="submit" name="buscar" value="buscar"><br>
Numero de usuaria <input type="text" pattern="[0-9]+">
<input type="submit" name="buscar" value="buscar"><br>
Teléfono<input type="tel" name="telephone" pattern="[0-9]+">
<input type="submit" name="buscar" value="buscar"><br>
<br>

<?php

	if (!isset($contact_list)) {
		echo("Después de buscar mucho no hemos encontrado a nadie con estos datos, comprueba que hayas metido bien los datos.");
	}
	

	if (isset($_POST['buscar'])){
			//asigna a la variable $name el valor que recoge de  'name'.   
			$name = filter_input(INPUT_POST, 'name');
			$user_id = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
			$user_dni = filter_input(INPUT_POST, "contact_list", FILTER_DEFAULT);
            $user_tfno = filter_input(INPUT_POST, 'telephone', FILTER_VALIDATE_INT);
		if (empty($name) and empty($user_id) and empty($user_dni) and empty($user_tfno)) {
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

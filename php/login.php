<?php
require_once 'conection.php'; 
require_once 'query.php';
require_once 'cookie.php';

if (isset($_POST['submit']))  {
    
    $conn = Connection::getConnection();
    
    $dni = filter_input(INPUT_POST, 'dni');
    $password = filter_input(INPUT_POST, 'pass');
    
    // Crear un hash de la contraseña
    $query_password_hash = Queries::check_pass();
    $stmt = $conn->prepare($query_password_hash);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    $get_user_id = Queries::get_user_id();
    $stmt = $conn->prepare($get_user_id);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $stmt->bind_result($id_user);
    $stmt->fetch();
    $stmt->close();

    echo "<h1>...$dni</h1>";

    if (password_verify($password, $stored_password)) {
        echo 'La contraseña es válida! <br>';
    
        // Generar una ID de sesión aleatoria
        $session_id = uniqid();
        $add_session = Queries::add_session($session_id, $id_user);
        $result = id_type_user($id_user, $conn);

        echo "<h1>typeuser: $result</h1>";
        
        if (mysqli_query($conn, $add_session)) {
    		// Guardar la información de la sesión en una cookie
            setcookie('session_id', $session_id, time() + 3600, '/');
            echo"$result";
            switch ($result){
                case 1:
                    header("Location: master.php");
                    break;
                case 2:
                    header("Location: active_member.php");
                    break;
                case 3:
                    header("Location: inactive_member.php");
                    break;
                case 4:
                    header("Location: inactive_member.php");
                    break;
                case 5:
                    header("Location: inactive_member.php");
                    break;
            }
            
        } else {
			echo "Error: " . $add_session . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
        
    } else {
        echo 'La contraseña no es válida.';
    }   
}

function id_type_user($id_user, $conn) {

    $query = Queries::query_id_type_user();

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user); 
    $stmt->execute();
    $stmt->bind_result($id_type_user);
    $stmt->fetch();
    $stmt->close();

    return $id_type_user;

    mysqli_free_result($result);
    mysqli_close($conn);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>acceso</title>
</head>
<body>
<div>
<p class="title">acceso</p>
<form action="login.php" method="POST"> 
DNI <input type="text" name="dni" require>  	
Contraseña<input type="password" name="pass"><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>

</form>
<p>
</div>
</body>
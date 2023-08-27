<?php
require 'conection.php'; 
require 'query.php';
require 'cookie.php';
//require 'new_user.php';
//check_cookie();

if (isset($_POST['submit']))  {
    
    $conn = getConnection();
    
    $id_user = filter_input(INPUT_POST, 'id_user', FILTER_VALIDATE_INT);
    $password = filter_input(INPUT_POST, 'pass');
    
    // Crear un hash de la contraseña
    $password_hash = check_pass($id_user);
    $stmt = $conn->prepare($password_hash);
    $stmt->bind_param("s", $id_user);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $stored_password)) {
        echo 'La contraseña es válida! <br>';
    
        // Generar una ID de sesión aleatoria
        $session_id = uniqid();
        $add_session = add_session($session_id, $id_user);
        $result = id_type_user($id_user);
        
        if (mysqli_query($conn, $add_session)) {
            read_cookie();
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

function id_type_user($id_user) {
    $conn = getConnection();
    $query = query_id_type_user($id_user, $conn);
    echo "<h1>$query</h1>";

    if ($query) {
        $query_result = $conn->query($query);

        $row = mysqli_fetch_assoc($query_result);
        return $row['id_type_user'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

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
<p><a href="new_shift.php">new shift</a></p>
<p><a href="update_shift.php">update shift</a></p>
<p><a href="delete_shift.php">delete shift</a></p>
<p><a href="new_user.php">new user</a></p>
<p><a href="update_user.php">update user</a></p>
<p><a href="delete_user.php">delete user</a></p>
</div>
<div>
<p class="title">acceso</p>
<form action="login.php" method="POST"> 
ID usuaria <input type="number" name="id_user" require>  	
Contraseña<input type="password" name="pass"><br>
<br>
<input type="submit" name="submit" value="submit">
<input type="reset" value="reset" name="reset"><br><br>

</form>
<p>
</div>
</body>

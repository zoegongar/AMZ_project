<?php
//carga las distintas páginas que se necesitan.
require 'conection.php'; 
require 'new_user.php';
// Iniciar la sesión
$conn = getConnection();

// Datos del usuario (ejemplo)
$user = "usuarioEjemplo";
$password = "contraseñaSegura123";

// Crear un hash de la contraseña
$contrasena_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el usuario y el hash de la contraseña en la base de datos
$sql = "INSERT INTO users (name, pass) VALUES ('$user', '$contrasena_hash')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();

// Mensaje de inicio de sesión
echo "¡Registro completado! Ahora puedes iniciar sesión.";

// Fin del ejemplo
?>

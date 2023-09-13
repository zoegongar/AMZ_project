<?php

use PHPUnit\Framework\TestCase;

require_once 'conection.php'; 
require_once 'query.php';
require_once 'check_data.php';
require_once 'cookie.php';
require_once 'validations.php';
require_once 'new_user.php';
include_once '/html/navigator_var.html';

class UserTest extends TestCase {
    public function testValidUserData() {
        // Simular datos de formulario válidos
        $_POST = [
            'user_type' => 1,
            'name' => 'John',
            'surname_1' => 'Doe',
            'surname_2' => 'Smith',
            'dni' => '12345678A',
            'telephone' => '123456789',
            'pass' => 'password123',
            'submit' => 'submit',
        ];

        // Capturar la salida del buffer de salida
        ob_start();
        include 'index.php';
        $output = ob_get_clean();

        // Verificar que la salida contiene el mensaje de éxito esperado
        $this->assertStringContainsString('Has creado a la socia John correctamente', $output);
    }

    // Puedes agregar más pruebas para otros escenarios (campos vacíos, datos inválidos, etc.)
}

?>
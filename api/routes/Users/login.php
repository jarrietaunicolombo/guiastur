<?php

namespace Api\Routes\Endopoint\Users;

use Api\Controllers\Users\LoginController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Users/LoginMobileController.php";

// Configuración de cabeceras para CORS
header("Access-Control-Allow-Origin: https://localhost:8100");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

// Log para indicar que se ha iniciado el script
error_log("Script de login iniciado");

// Respuesta a las solicitudes de preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Manejo de solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Solicitud POST recibida");

    // Obtener los datos enviados en el cuerpo de la solicitud (formato JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    error_log("Datos recibidos: " . json_encode($input));

    // Verificar si los campos email y password están presentes
    if (isset($input['email']) && isset($input['password'])) {
        error_log("Email y contraseña detectados en la solicitud");

        // Verificar si los campos no están vacíos
        if (empty($input['email']) || empty($input['password'])) {
            error_log("Campos vacíos: Email o contraseña están vacíos.");
            http_response_code(400);
            echo json_encode(["error" => "El email y la contraseña no pueden estar vacíos."]);
            exit();
        }

        // Preparar la solicitud para el controlador
        $request = [
            "action" => "login",
            "email" => $input['email'],
            "password" => $input['password']
        ];

        error_log("Datos procesados para login: " . json_encode($request));

        // Instanciar el controlador y manejar la solicitud
        try {
            $controller = new LoginController();
            $controller->handleRequest($request);
        } catch (\Exception $e) {
            error_log("Error durante la autenticación: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Error en el servidor: " . $e->getMessage()]);
        }
    } else {
        error_log("Error: Email o contraseña no están presentes en la solicitud.");
        http_response_code(400);
        echo json_encode(["error" => "El email y la contraseña son obligatorios."]);
    }
} else {
    error_log("Método HTTP no permitido: " . $_SERVER['REQUEST_METHOD']);
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}

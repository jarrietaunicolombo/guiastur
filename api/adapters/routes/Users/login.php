<?php

namespace Api\Routes\Endopoint\Users;

use Api\Controllers\Users\LoginController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Users/LoginMobileController.php";

$allowedOrigins = [
    "http://localhost:8100",
    "https://localhost:8100",
    "http://192.168.137.57:8100",
    "http://localhost:8100"
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Credentials: true');
} else {
    http_response_code(403);
    echo json_encode(["error" => "Origen no permitido"]);
    exit();
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los datos enviados en el cuerpo de la solicitud (formato JSON)
    $input = json_decode(file_get_contents('php://input'), true);


    // Verificar si los campos email y password están presentes
    if (isset($input['email']) && isset($input['password'])) {

        // Verificar si los campos no están vacíos
        if (empty($input['email']) || empty($input['password'])) {
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


        // Instanciar el controlador y manejar la solicitud
        try {
            $controller = new LoginController();
            $controller->handleRequest($request);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error en el servidor: " . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "El email y la contraseña son obligatorios."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}

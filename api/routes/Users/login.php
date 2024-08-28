<?php

header("Access-Control-Allow-Origin: https://guiastur-mobile-app.test:4200");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Referrer-Policy: no-referrer");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Users/LoginControllerApi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['email']) && isset($input['password'])) {
        $request = [
            "action" => "login",
            "email" => $input['email'],
            "password" => $input['password']
        ];

        $controller = new LoginController();
        $controller->handleRequest($request);
    } else {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(["error" => "El email y la contraseña son obligatorios."]);
    }
} else {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}

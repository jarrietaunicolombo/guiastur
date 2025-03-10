<?php

namespace Api\Routes;

use Api\Controllers\Atenciones\CreateAtencionMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Atenciones/CreateAtencionMobileController.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Definir rutas y controladores
$routes = [
    'POST atencion' => new CreateAtencionMobileController()
];

$ruta = $_GET['ruta'] ?? '';

foreach ($routes as $route => $controller) {
    [$routeMethod, $routePath] = explode(' ', $route);
    
    if ($_SERVER['REQUEST_METHOD'] === $routeMethod && $ruta === $routePath) {
        $request = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;
        $controller->handleRequest($request);
        exit();
    }
}

// Si no coincide ninguna ruta
http_response_code(405);
echo json_encode([
    "status" => "error",
    "message" => "Método no permitido o ruta incorrecta"
]);

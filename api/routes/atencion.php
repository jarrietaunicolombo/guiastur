<?php

namespace Api\Routes;

use Api\Controllers\Atenciones\CreateAtencionMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Atenciones/CreateAtencionMobileController.php";

$allowedOrigins = [
    "http://localhost:8100",
    "https://localhost:8100",
    "http://192.168.137.57:8100",
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

$routes = [
    'POST atencion' => new CreateAtencionMobileController()
];

$ruta = $_GET['ruta'] ?? '';

error_log("📌 Petición recibida en atencion.php - Método: {$_SERVER['REQUEST_METHOD']} - Ruta: $ruta");

foreach ($routes as $route => $controller) {
    [$routeMethod, $routePath] = explode(' ', $route);

    error_log("🔍 Comparando ruta - Método: $routeMethod, Ruta: $routePath");

    if ($_SERVER['REQUEST_METHOD'] === $routeMethod && $ruta === $routePath) {
        error_log("✅ Ruta encontrada: $ruta, ejecutando controlador...");
        $request = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;
        $controller->handleRequest($request);
        exit();
    }
}

error_log("❌ Ruta no encontrada o método incorrecto.");
http_response_code(405);
echo json_encode(["status" => "error", "message" => "Método no permitido o ruta incorrecta"]);

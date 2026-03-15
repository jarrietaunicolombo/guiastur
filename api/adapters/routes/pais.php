<?php

namespace Api\Routes;

use Api\Controllers\Paises\GetPaisesMobileController;
use Api\Controllers\Paises\GetPaisByIdMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Paises/GetPaisesMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Paises/GetPaisByIdMobileController.php";

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

header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$routes = [
    'GET paises' => new GetPaisesMobileController(),
    'GET paises/id' => new GetPaisByIdMobileController(),
];

$ruta = $_GET['ruta'] ?? '';

foreach ($routes as $route => $controller) {
    [$routeMethod, $routePath] = explode(' ', $route);

    if ($_SERVER['REQUEST_METHOD'] === $routeMethod) {
        if ($routePath === 'paises/id' && isset($_GET['id'])) {
            $controller->handleRequest($_GET['id']);
            exit();
        } elseif ($ruta === $routePath) {
            $controller->handleRequest();
            exit();
        }
    }
}

http_response_code(405);
echo json_encode([
    "status" => "error",
    "message" => "Método no permitido o ruta incorrecta"
]);

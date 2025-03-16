<?php

namespace Api\Routes;

use Api\Controllers\Recaladas\CreateRecaladaMobileController;
use Api\Controllers\Recaladas\GetRecaladasMobileController;
use Api\Controllers\Recaladas\GetRecaladasByBuqueMobileController;
use Api\Controllers\Recaladas\GetRecaladasInThePortMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Recaladas/CreateRecaladaMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Recaladas/GetRecaladasMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Recaladas/GetRecaladasByBuqueMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Recaladas/GetRecaladasInThePortMobileController.php";


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
    'POST recaladas' => new CreateRecaladaMobileController(),
    'GET recaladas' => new GetRecaladasMobileController(),
    'GET recaladas/buque' => new GetRecaladasByBuqueMobileController(),
    'GET recaladas/puerto' => new GetRecaladasInThePortMobileController()
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

http_response_code(405);
echo json_encode([
    "status" => "error",
    "message" => "Método no permitido o ruta incorrecta"
]);


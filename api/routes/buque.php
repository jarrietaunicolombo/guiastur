<?php

namespace Api\Routes;

use Api\Controllers\Buques\CreateBuqueMobileController;
use Api\Controllers\Buques\GetBuquesMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Buques/CreateBuqueMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Buques/GetBuquesMobileController.php";

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

// Definir rutas válidas y sus controladores
$routes = [
    'POST buques' => new CreateBuqueMobileController(),
    'GET buques' => new GetBuquesMobileController()
];

// Obtener la ruta limpia desde el parámetro 'ruta' en la query string
$ruta = explode('?', $_GET['ruta'] ?? '')[0]; // Elimina los parámetros extra
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 20;

// Buscar coincidencia en las rutas definidas
foreach ($routes as $route => $controller) {
    [$routeMethod, $routePath] = explode(' ', $route);
    

    if ($_SERVER['REQUEST_METHOD'] === $routeMethod && $ruta === $routePath) {

        // Pasar los datos del request correctamente
        $requestData = json_decode(file_get_contents("php://input"), true) ?? [];
        $controller->handleRequest($requestData);
        
        exit();
    }
}

// Si ninguna ruta coincide, devolver error
http_response_code(405);
echo json_encode([
    "status" => "error",
    "message" => "Método no permitido o ruta incorrecta"
]);

<?php

namespace Api\Routes;

use Api\Controllers\Recaladas\CreateRecaladaMobileController;
use Api\Controllers\Recaladas\GetRecaladasMobileController;
use Api\Controllers\Recaladas\GetRecaladasByBuqueController;
use Api\Controllers\Recaladas\GetRecaladasInThePortMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Recaladas/CreateRecaladaMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Recaladas/GetRecaladasMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Recaladas/GetRecaladasByBuqueMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Recaladas/GetRecaladasInThePortMobileController.php";

function logError($message) {
    $logFile = $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/logs/error_log.txt";
    $date = date('Y-m-d H:i:s');
    error_log("[$date] $message\n", 3, $logFile);
}

logError("== Iniciando solicitud a recaladas ==");
logError("Método HTTP recibido: " . $_SERVER['REQUEST_METHOD']);
logError("URL solicitada: " . $_SERVER['REQUEST_URI']);
logError("Headers recibidos: " . json_encode(getallheaders()));
logError("Parámetros GET: " . json_encode($_GET));
logError("Parámetros POST: " . json_encode($_POST));

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
    'POST recaladas' => new CreateRecaladaMobileController(),
    'GET recaladas' => new GetRecaladasMobileController(),
    'GET recaladas/buque' => new GetRecaladasByBuqueController(),
    'GET recaladas/puerto' => new GetRecaladasInThePortMobileController()
];

// Obtener la ruta limpia desde el parámetro 'ruta' en la query string
$ruta = $_GET['ruta'] ?? '';

logError("Ruta solicitada: {$_SERVER['REQUEST_METHOD']} $ruta");

// Buscar coincidencia en las rutas definidas
foreach ($routes as $route => $controller) {
    [$routeMethod, $routePath] = explode(' ', $route);
    
    logError("Comparando con ruta: $routeMethod $routePath");

    if ($_SERVER['REQUEST_METHOD'] === $routeMethod && $ruta === $routePath) {
        logError("Ruta encontrada: ejecutando controlador");
        $request = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;
        $controller->handleRequest($request);
        exit();
    }
}

// Si ninguna ruta coincide, devolver error
logError("Ruta no encontrada. Respondiendo con 405");
http_response_code(405);
echo json_encode([
    "status" => "error",
    "message" => "Método no permitido o ruta incorrecta"
]);


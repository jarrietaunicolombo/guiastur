<?php

namespace Api\Routes;

use Api\Controllers\Users\CreateUserMobileController;
use Api\Controllers\Users\LoginController;
use Api\Controllers\Users\LogoutController;
use Api\Controllers\Users\RefreshTokenController;
use MeMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Users/CreateUserMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Users/LoginMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Users/LogoutMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Users/RefreshTokenController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/controllers/Users/MeMobileController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/UsuarioRepository.php";

// CORS
$allowedOrigins = [
    "http://localhost:8100",
    "https://localhost:8100",
    "http://192.168.137.57:8100"
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

// Definición de rutas
$usuarioRepository = new \UsuarioRepository();

$routes = [
    'POST create-user'    => new CreateUserMobileController($usuarioRepository),
    'POST login'          => new LoginController(),
    'POST logout'         => new LogoutController(),
    'POST refresh-token'  => new RefreshTokenController(),
    'GET me'              => new MeMobileController()
];

$ruta = $_GET['ruta'] ?? '';
$metodo = $_SERVER['REQUEST_METHOD'];

foreach ($routes as $definicion => $controller) {
    [$method, $path] = explode(' ', $definicion);

    if ($method === $metodo && $ruta === $path) {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;
        $controller->handleRequest($input);
        exit();
    }
}

http_response_code(404);
echo json_encode([
    "error" => "Ruta o método no encontrado"
]);

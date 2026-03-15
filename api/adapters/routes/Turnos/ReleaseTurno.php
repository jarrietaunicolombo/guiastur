<?php

namespace Api\Routes\Endpoint\Turnos;

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

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Turnos/ReleaseTurnoMobileController.php";

use Api\Controllers\Turnos\ReleaseTurnoMobileController;

$controller = new ReleaseTurnoMobileController();
$controller->handleRequest($_POST);

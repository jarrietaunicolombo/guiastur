<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Atenciones/CreateAtencionMobileController.php";

$createAtencionMobileController = new \CreateAtencionMobileController();

header("Access-Control-Allow-Origin: https://localhost:8100");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_URI'] === '/api/atencion/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $createAtencionMobileController->handleRequest($_POST);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ruta no encontrada']);
    http_response_code(404);
    exit();
}

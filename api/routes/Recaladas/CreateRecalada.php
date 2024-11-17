<?php

namespace Api\Routes\Endopoint\Recaladas;

use Api\Controllers\Recaladas\CreateRecaladaMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Recaladas/CreateRecaladaMobileController.php";

header("Access-Control-Allow-Origin: https://localhost:8100");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$createRecaladaController = new CreateRecaladaMobileController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    $createRecaladaController->handleRequest($request);
} else {
    header('Content-Type: application/json', true, 405);
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido"
    ]);
}

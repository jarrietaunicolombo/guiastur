<?php

namespace Api\Routes\Endopoint\Buques;

use Api\Controllers\Buques\CreateBuqueMobileController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Buques/CreateBuqueMobileController.php";

header("Access-Control-Allow-Origin: https://guiastur-mobile-app.test:4200");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$createBuqueController = new CreateBuqueMobileController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);
    $createBuqueController->handleRequest($request);
} else {
    header('Content-Type: application/json', true, 405);
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido"
    ]);
}

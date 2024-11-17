<?php

use Api\Controllers\Buques\GetBuquesMobileControllerApi;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Buques/GetBuquesMobileControllerApi.php";

header("Access-Control-Allow-Origin: https://localhost:8100");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$controller = new GetBuquesMobileControllerApi();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $request = $_GET;
    $controller->handleRequest($request);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $request = json_decode(file_get_contents('php://input'), true);
    $controller->handleRequest($request);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
    exit();
}

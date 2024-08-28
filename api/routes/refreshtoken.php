<?php

header("Access-Control-Allow-Origin: https://guiastur-mobile-app.test:4200"); // El dominio de tu aplicación
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/RefreshTokenController.php";

$controller = new RefreshTokenController();
$controller->handleRequest();

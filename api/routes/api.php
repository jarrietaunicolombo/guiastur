<?php
/*
header("Access-Control-Allow-Origin: https://guiastur-mobile-app.test:4200");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
}

$requestUri = $_SERVER['REQUEST_URI'];

error_log("Request URI recibida: " . $requestUri, 0);

if (strpos($requestUri, '/api/users/create') !== false) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/routes/Users/createUsers.php";
} elseif (strpos($requestUri, '/api/users/login') !== false) {
    error_log("Redirigiendo a login.php", 0);
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/routes/Users/login.php";
} elseif (strpos($requestUri, '/api/users/logout') !== false) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/routes/Users/logout.php";
} elseif (strpos($requestUri, '/api/users/refreshtoken') !== false) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/routes/Users/refreshtoken.php";
} elseif (strpos($requestUri, '/api/buques/create') !== false) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/routes/Buques/CreateBuque.php";
} else {
    error_log("Ruta no encontrada: " . $requestUri, 0);
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Ruta no encontrada"
    ]);
}

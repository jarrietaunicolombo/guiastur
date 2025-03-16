<?php
function handleCors() {
    $allowedOrigins = [
        "http://localhost:8100",
        "https://localhost:8100",
        "https://41a0-191-95-53-225.ngrok-free.app"
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
    header("Content-Type: application/json; charset=utf-8'");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}

<?php

namespace Api\Routes\Endopoint\Users;

use Api\Controllers\Users\RefreshTokenController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Users/RefreshTokenController.php";

header("Access-Control-Allow-Origin: https://localhost:8100");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$refreshTokenController = new RefreshTokenController();
$refreshTokenController->handleRequest();

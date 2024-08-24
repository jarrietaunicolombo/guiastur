<?php

use api\controllers\users\LoginController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Users/LoginControllerApi.php";


$request = json_decode(file_get_contents('php://input'), true);
$request['is_api'] = 'true';

$controller = new LoginController();
$controller->handleRequest($request);

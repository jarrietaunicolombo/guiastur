<?php

use api\controllers\users\LogoutController;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Users/LogoutControllerApi.php";

$request = ["action" => "logout", "is_api" => "true"];

$controller = new LogoutController();
$controller->handleRequest($request);

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/controllers/Users/createUsersControllerApi.php";

$controller = new CreateUserController();
$request = json_decode(file_get_contents('php://input'), true);
$controller->handleRequest($request);

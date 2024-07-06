<?php
// /public/index.php

require_once '../../Controllers/Users/CreateUserController.php';
// require_once '../../Controllers/Users/CreateUserGuiaController.php';

session_start();
if (!isset($accion)) {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
    }
}

switch ($action) {
    case 'create_user':
        $controller = new CreateUserController();
        $controller->createUser();
        break;
    // case 'create_user_guia':
    //     $controller = new CreateUserGuiaController();
    //     $controller->createUserGuia();
    //     break;
    case 'show_user':
        require_once 'show.php';
        break;
    case 'show_user_guia':
        require_once 'ShowGuia.php';
        break;
    default:
        echo "Acción no válida";
        break;
}

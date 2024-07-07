<?php
// /public/index.php

require_once '../../Controllers/Users/CreateUserController.php';
require_once '../../Controllers/Users/LoginController.php';
require_once '../../Controllers/SessionUtility.php';


$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
if (isset($actionGet)){
    $action = $actionGet;
}
else if (isset($actionPost)){ 
    $action = $actionPost;
}else{
    $action = NULL;
}

if ($action === NULL) {
    clear_session();
    header('Location: login.php?message$Accion invalidaxxx');
    exit;
}

if (($action === 'login' && isset($_GET["action"])) || ($action === 'logout' && isset($_GET["action"]))) {
    clear_session();
    header('Location: login.php');
    exit;
}

if (($action === 'create' && isset($_GET["action"])) ) {
    header('Location: create.php');
    exit;
}

    switch ($action) {
        case 'login':
            $controller = new LoginController();
            $controller->handleRequest($_POST);
            break;
        case 'create':
            $controller = new CreateUserController();
            $controller->createUser($_POST);
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


function clear_session()
{
    if (session_status() != PHP_SESSION_NONE) {
        session_destroy();
    }
}
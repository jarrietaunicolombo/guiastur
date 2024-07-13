<?php
// /public/index.php

require_once '../../Controllers/Users/CreateUserController.php';
require_once '../../Controllers/Users/ActivateUserAccountController.php';
require_once '../../Controllers/Users/LoginController.php';
require_once '../../Controllers/SessionUtility.php';


$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
$action = $actionGet ?? $actionPost;
if ($action === null) {
    clear_session("Accion invalida");
    exit;
}

if ($action === 'login' && isset($_GET["action"])){
    clear_session();
    exit;
}

if (($action === 'logout' && isset($_POST["action"]))) {
    clear_session("Accion invalida");
    exit;
}

if (($action === 'create' && isset($_GET["action"])) ) {
    header('Location: create.php');
    exit;
}

if (($action === 'activate' && isset($_POST["action"])) ) {
   clear_session("Accion invalida");
   exit;
}

if (($action === 'activating' && isset($_GET["action"])) ) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    case 'login':
        $controller = new LoginController();
        $controller->handleRequest($_POST);
        break;
    case 'logout':
            $controller = new LoginController();
            $controller->handleRequest($_GET);
            break;
    case 'create':
        $controller = new CreateUserController();
        $controller->handleRequest($_POST);
        break;
    case 'activate':
            $controller = new ActivateUserAccountController();
            $controller->handleRequest($_GET);
            break;
    case 'activating':
            $controller = new ActivateUserAccountController();
            $controller->handleRequest($_POST);
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
        clear_session() ;
        
        header('Location: login.php?');
        break;
}


function clear_session(string $message = "")
{
    session_destroy();
    session_start();
    SessionUtility::startSession() ;
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
    header('Location: login.php');
    exit;
}
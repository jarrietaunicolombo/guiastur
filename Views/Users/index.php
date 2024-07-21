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

if ($action === 'login' && isset($_GET["action"])) {
    clear_session();
    exit;
}

if (($action === 'logout' && isset($_POST["action"]))) {
    clear_session("Accion invalida");
    exit;
}

if (($action === 'activate' && isset($_POST["action"]))) {
    clear_session("Accion invalida");
    exit;
}

if (($action === 'activating' && isset($_GET["action"]))) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    case 'menu':
        header("Location: menu.php");
        exit;
    case 'login':
        $controller = new LoginController();
        $controller->handleRequest($_POST);
        exit;
    case 'logout':
        $controller = new LoginController();
        $controller->handleRequest($_GET);
        exit;
    case 'create':
       echo (new CreateUserController())->handleRequest($_REQUEST);
        exit;
    case 'activate':
        $controller = new ActivateUserAccountController();
        $controller->handleRequest($_GET);
        exit;
    case 'activating':
        $controller = new ActivateUserAccountController();
        $controller->handleRequest($_POST);
        exit;

    // case 'create_user_guia':
    //     $controller = new CreateUserGuiaController();
    //     $controller->createUserGuia();
    //     exit;
    // case 'show_user':
    //     require_once 'show.php';
    //     exit;
    // case 'show_user_guia':
    //     require_once 'ShowGuia.php';
    //     exit;
    default:
        clear_session();
        header('Location: login.php?');
        exit;
}


function clear_session(string $message = "")
{
    session_destroy();
    session_start();
    SessionUtility::startSession();
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
    header('Location: login.php');
    exit;
}
<?php
require_once '../../Controllers/Recaladas/CreateRecaladaController.php';
require_once '../../Controllers/Recaladas/GetRecaladasController.php';
require_once '../../Controllers/Recaladas/GetRecaladasInThePortController.php';
require_once '../../Controllers/Recaladas/GetRecaladasByBuqueController.php';

$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
$action = $actionGet ?? $actionPost;

if ($action === null) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    case 'create':
        echo (new CreateRecaladaController())->handleRequest($_REQUEST);
        exit;
    case 'listall':
        (new GetRecaladasController())->handleRequest($_GET);
        exit;
    case 'listinport':
        (new GetRecaladasInThePortController())->handleRequest($_GET);
        exit;
    case 'listbybuque':
        (new GetRecaladasByBuqueController())->handleRequest($_GET);
        break;
    case 'menu':
        header("Location: menu.php");
        exit;
    default:
        clear_session();
        exit;
}


function clear_session(string $message = "")
{
    SessionUtility::clearAllSession();
    SessionUtility::startSession();
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
    header('Location: ../Users/login.php');
    exit;
}
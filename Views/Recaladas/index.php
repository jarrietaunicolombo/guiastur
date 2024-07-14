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
        (new CreateRecaladaController())->handleRequest($_REQUEST);
        break;
    case 'listall':
        (new GetRecaladasController())->handleRequest($_GET);
        break;
    case 'listinport':
        (new GetRecaladasInThePortController())->handleRequest($_GET);
        break;
    case 'listbybuque':
            (new GetRecaladasByBuqueController())->handleRequest($_GET);
            break;
    default:
        clear_session() ;
        break;
}


function clear_session(string $message = "")
{
    SessionUtility::clearAllSession();
    SessionUtility::startSession() ;
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
    header('Location: ../Users/login.php');
    exit;
}
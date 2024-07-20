<?php
require_once '../../Controllers/Atenciones/GetAtencionesByRecaladaController.php';
require_once '../../Controllers/Atenciones/CreateAtencionController.php';


$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
$action = $actionGet ?? $actionPost;

if ($action === null) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    case 'create':
        (new CreateAtencionController())->handleRequest($_REQUEST);
        break;
    // case 'listall':
    //     (new GetRecaladasController())->handleRequest($_GET);
    //     break;
    // case 'listinport':
    //     (new GetRecaladasInThePortController())->handleRequest($_GET);
    //     break;
    case 'listbyrecalada':
        (new GetAtencionesByRecaladaController())->handleRequest($_GET);
        exit;
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
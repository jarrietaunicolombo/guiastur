<?php
require_once '../../Controllers/Atenciones/GetAtencionesByRecaladaController.php';


$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
$action = $actionGet ?? $actionPost;

if ($action === null) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    // case 'create':
    //     (new CreateRecaladaController())->handleRequest($_REQUEST);
    //     break;
    // case 'listall':
    //     (new GetRecaladasController())->handleRequest($_GET);
    //     break;
    // case 'listinport':
    //     (new GetRecaladasInThePortController())->handleRequest($_GET);
    //     break;
    case 'listbyrecalada':
            (new GetAtencionesByRecaladaController())->handleRequest($_GET);
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
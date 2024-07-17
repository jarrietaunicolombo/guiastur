<?php
require_once '../../Controllers/Turnos/GetTurnosByAtencionController.php';
require_once '../../Controllers/Turnos/GetNextTurnosAllController.php';
require_once '../../Controllers/Turnos/UseTurnoController.php';


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
    case 'listbyatencion':
        (new GetTurnosByAtencionController())->handleRequest($_GET);
        break;
    case 'listnextall':
         (new GetNextTurnosAllController())->handleRequest($_GET);
        break;
    case 'usarturno':
        echo (new UseTurnoController())->handleRequest($_POST);
        exit();

    default:
        clear_session();
        break;
}


function clear_session(string $message = "")
{
    SessionUtility::clearAllSession();
    SessionUtility::startSession();
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
    header('Location: ../Users/login.php');
    exit;
}
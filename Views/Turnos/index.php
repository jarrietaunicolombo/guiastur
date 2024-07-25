<?php
require_once '../../Controllers/Turnos/GetTurnosByAtencionController.php';
require_once '../../Controllers/Turnos/GetNextAllTurnosByStatusController.php';
require_once '../../Controllers/Turnos/CreateTurnoController.php';
require_once '../../Controllers/Turnos/UseTurnoController.php';
require_once '../../Controllers/Turnos/ReleaseTurnoController.php';
require_once '../../Controllers/Turnos/FinishTurnoController.php';
require_once '../../Domain/Constants/TurnoStatusEnum.php';


$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
$action = $actionGet ?? $actionPost;

if ($action === null) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    case 'menu':
        header("Location: menu.php");
        exit;
    case 'create':
        echo (new CreateTurnoController())->handleRequest($_REQUEST);
        exit;
    case 'listall':
    //     (new GetRecaladasController())->handleRequest($_GET);
    //     break;
    // case 'listinport':
    //     (new GetRecaladasInThePortController())->handleRequest($_GET);
    //     break;
    case 'listbyatencion':
        (new GetTurnosByAtencionController())->handleRequest($_GET);
        exit;
    case 'listnextall':
        $_GET["action"] = TurnoStatusEnum::CREATED;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
    case 'usedtoday':
        $_GET["action"] = TurnoStatusEnum::INUSE;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
    case 'releasedtoday':
        $_GET["action"] = TurnoStatusEnum::RELEASE;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
        exit;
    case 'finishedtoday':
        $_GET["action"] = TurnoStatusEnum::FINALIZED;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
        exit;
    case 'usarturno':
        echo (new UseTurnoController())->handleRequest($_POST);
        exit();
    case 'liberarturno':
        echo (new ReleaseTurnoController())->handleRequest($_POST);
        exit();
    case 'finalizarturno':
        echo (new FinishTurnoController())->handleRequest($_POST);
        exit();
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
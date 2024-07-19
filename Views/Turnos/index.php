<?php
require_once '../../Controllers/Turnos/GetTurnosByAtencionController.php';
require_once '../../Controllers/Turnos/GetNextAllTurnosByStatusController.php';
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
        $_GET["action"] = TurnoStatusEnum::CREATED;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
    case 'usedtoday':
        $_GET["action"] = TurnoStatusEnum::INUSE;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
    case 'releasedtoday':
        $_GET["action"] = TurnoStatusEnum::RELEASE;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
        break;
    case 'finishedtoday':
        $_GET["action"] = TurnoStatusEnum::FINALIZED;
        (new GetNextAllTurnosByStatusController())->handleRequest($_GET);
        break;
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
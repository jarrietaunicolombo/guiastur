<?php
require_once '../../Controllers/Buques/CreateBuqueController.php';
require_once '../../Controllers/Buques/GetBuquesController.php';

$actionGet = @$_GET['action'];
$actionPost = @$_POST['action'];
$action = $actionGet ?? $actionPost;

if ($action === null) {
    clear_session("Accion invalida");
    exit;
}

if ($action === 'create' && isset($_GET["action"])){
    header('Location: create.php');
    exit;
}

if ($action === 'listall' && isset($_POST["action"])) {
    clear_session("Accion invalida");
    exit;
}

switch ($action) {
    case 'create':
        (new CreateBuqueController())->handleRequest($_POST);
        break;
    case 'listall':
        (new GetBuquesController())->handleRequest($_GET);
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
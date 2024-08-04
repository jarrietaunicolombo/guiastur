<?php
require_once '../../Controllers/SessionUtility.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';

SessionUtility::startSession();
$usuarioLogin = $_SESSION[ItemsInSessionEnum::USER_LOGIN];
if (!isset($usuarioLogin)) {
    SessionUtility::clearAllSession();
    SessionUtility::startSession();
    $errorMessage = "Accion denegada, primero debe iniciar sesion";
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
    header('Location: ../Users/login.php');
    exit;
}

$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/createbuque.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
    <div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Crear Buque
    </div>
    <?php require_once "../menu.php" ?>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        </a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=listall">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
        </a>
    </div>
    <div class="form-wrapper">
        <div class="form-container">
            <h2>Ingrese los datos del buque</h2>

            <form action="index.php" method="post" id="buque-form">
                <input type="hidden" name="action" value="create" id="action">
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" id="codigo" placeholder="El codigo del buque">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" id="nombre" required placeholder="El nombre del buque">
                </div>
                <div class="form-group">
                    <strong>Usuario:</strong>
                    <span><?= @$usuarioLogin->getNombre() ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Crear Buque" id="button-create">
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../Js/createbuque.js"></script>
    
</body>

</html>
<?php

SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
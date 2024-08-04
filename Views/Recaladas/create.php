<?php
require_once '../../Controllers/SessionUtility.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';
require_once '../../Application/UseCases/GetBuques/Dto/GetBuquesResponse.php';
require_once '../../Application/UseCases/GetPaises/Dto/GetPaisesResponse.php';

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

$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? null;
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? null;
$buquesResponse = $_SESSION[ItemsInSessionEnum::LIST_BUQUES] ?? null;
$paisesResponse = $_SESSION[ItemsInSessionEnum::LIST_PAISES] ?? null;
$erroMessages = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] ?? null;
$requestData = @$_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] ?? null;

if ($errorMessage) {
    $infoMessage = null;
} else if ($infoMessage) {
    $errorMessage = null;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/createrecalada.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>

<div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Crear Recalada
    </div>
    <?php require_once "../menu.php" ?>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Recaladas/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        </a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Recaladas/index.php?action=listall">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
        </a>
    </div>

    <div class="content-zone">
        <div class="form-wrapper">
            <div class="form-container">
                <?php if (@$paisesResponse === null || count(@$paisesResponse->getPaises()) < 1): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let error = "No existen Paises disponibles. Menú Paises/Crear";
                            showAlert("error", "", error, false);
                        };
                    </script>
                <?php endif; ?>

                <?php if (@$buquesResponse !== null && count(@$buquesResponse->getBuques()) > 0 && @$paisesResponse !== null && count(@$paisesResponse->getPaises()) > 0): ?>
                    <form action="index.php" method="POST" id="recalada-form">
                        <input type="hidden" name="action" value="create" id="action">
                        <div class="form-group">
                            <label for="buque_id">Buque:</label>
                            <select name="buque_id" id="buque_id" required>
                                <option value="" disabled selected>Seleccione uno...</option>
                                <?php foreach ($buquesResponse->getBuques() as $recalada): ?>
                                    <option value="<?= @$recalada->getId() ?>"
                                        <?= (@$recalada->getId() == @$requestData["buque_id"]) ? "selected" : "" ?>>
                                        <?= $recalada->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="error-buque" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="pais_id">País:</label>
                            <select name="pais_id" id="pais_id" required>
                                <option value="" disabled selected>Seleccione uno...</option>
                                <?php foreach ($paisesResponse->getPaises() as $pais): ?>
                                    <option value="<?= @$pais->getId() ?>" <?= (@$pais->getId() == @$requestData["pais_id"]) ? "selected" : "" ?>><?= $pais->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="error-pais" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="fecha_arribo">Fecha de Arribo:</label>
                            <input type="datetime-local" id="fecha_arribo" name="fecha_arribo" required
                                value="<?= @$requestData["fecha_arribo"] ?? "" ?>">
                            <span id="error-arribo" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="fecha_zarpe">Fecha de Zarpe:</label>
                            <input type="datetime-local" id="fecha_zarpe" name="fecha_zarpe" required
                                value="<?= @$requestData["fecha_zarpe"] ?? "" ?>">
                            <span id="error-zarpe" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="total_turistas">Total Turistas:</label>
                            <input type="number" id="total_turistas" name="total_turistas" required
                                value="<?= @$requestData["total_turistas"] ?? "" ?>">
                            <span id="error-turistas" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones:</label>
                            <textarea id="observaciones"
                                name="observaciones"><?= @$requestData["observaciones"] ?? "" ?></textarea>
                        </div>

                        <div class="form-group">
                            <strong>Usuario:</strong>
                            <span><?= $usuarioLogin->getNombre() ?></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Crear Recalada" id="button-create">
                            <button type="reset">Reset</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../Js/createrecalada.js"></script>
    <script src="../Js/index.js"></script>
    <script>
     

    </script>
</body>

</html>

<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGES);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::RECALADA_REQUEST_CREATING);
?>
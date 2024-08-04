<?php
require_once '../../Controllers/SessionUtility.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';
require_once '../../Application/UseCases/GetSupervisor/Dto/GetSupervisorResponse.php';
require_once "../../Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once '../../Application/UseCases/GetRecaladas/GetRecaladasService.php';

SessionUtility::startSession();
$usuarioLogin = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
if ($usuarioLogin === null) {
    SessionUtility::clearAllSession();
    SessionUtility::startSession();
    $errorMessage = "Accion denegada, primero debe iniciar sesion";
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
    header('Location: ../Users/login.php');
    exit;
}
$supervisores = @$_SESSION[ItemsInSessionEnum::LIST_SUPERVISORES] ?? null;
$recalada = @$_SESSION[ItemsInSessionEnum::FOUND_RECALADA] ?? null;
$recaladas = @$_SESSION[ItemsInSessionEnum::LIST_RECALADAS] ?? null;
$baseUrl = UrlHelper::getUrlBase();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de turnos para guias de turismo</title>
    <link rel="stylesheet" href="../Css/createatencion.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
    <div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Crear Atencion
    </div>
    <?php require_once "../menu.php" ?>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Atenciones/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        </a>
        <a href="#">
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
                <?php if (@$supervisores === null || count(@$supervisores) < 1): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let title = "No hay supervisores";
                            let message = "Crear usuarios: Menu/Usuarios/Crear Usuario";
                            showSimpleAlert("error", title, message);
                        };
                    </script>
                <?php endif; ?>

                <?php if ($recalada === null && ($recaladas === null || count(@$recaladas->getRecaladas()) < 1)): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let title = "No hay recaladas disponibles";
                            let message = "Crear Recalada: Menu/Recaldas/Crear Recalda";
                            showSimpleAlert("error", title, message);
                        };
                    </script>
                <?php endif; ?>
                <?php if ($recaladas !== null && count(@$recaladas->getRecaladas()) >  0): ?>
                    <script>
                        window.onload = function(){
                            let recaladas = <?= $recaladas->toJSON(); ?>;
                            loadData(recaladas);
                        };
                    </script>

                <?php endif; ?>
                <div class="session-data">
                    <p><strong>Usuario ID: </strong> <span
                            id="usuario"><?= ($usuarioLogin) ? $usuarioLogin->getNombre() : "" ?></span></p>
                    <p><strong>Buque: </strong> <span
                            id="buque"><?= ($recalada) ? $recalada->getBuqueNombre() : "" ?></span>
                        <strong>Recaldada: </strong><span
                            id="recalada"><?= ($recalada) ? $recalada->getRecaladaId() : "" ?></span>
                    </p>
                    <p><strong>Arribo:</strong>
                        <span
                            id="arribo"><?= ($recalada) ? $recalada->getFechaArribo()->format("Y-m-d H:i:s") : "" ?></span>
                    </p>
                    <p><strong>Zarpe:</strong>
                        <span
                            id="zarpe"><?= ($recalada) ? $recalada->getFechaZarpe()->format("Y-m-d H:i:s") : "" ?></span>
                    </p>
                </div>

                <form action="index.php" method="POST" id="atencion-form">
                    <input type="hidden" name="action" value="create" id="action">
                    <?php if ($recaladas !== null && count(@$recaladas->getRecaladas()) >  0): ?>
                        
                    <div class="form-group">
                        <label for="buque">Buques:</label>
                        <select name="buque_id" id="buque_id" required>
                            <option value="" disabled selected>Seleccione uno...</option>
                        </select>
                        <span id="error-buque" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="recalada_id">Recaladas:</label>
                        <select name="recalada_id" id="recalada_id" required>
                            <option value="" disabled selected>Seleccione una...</option>

                        </select>
                        <span id="error-recalada" style="color: red;"></span>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="supervisor_id">Supervisor:</label>
                        <select name="supervisor_id" id="supervisor_id" required>
                            <option value="" disabled selected>Seleccione uno...</option>
                            <?php foreach ($supervisores as $supervisor): ?>
                                <option value="<?= @$supervisor->getSupervisor()->getCedula() ?>"
                                    <?= (@$supervisor->getUsuario()->getId() == @$usuarioLogin->getId()) ? "selected" : "" ?>>
                                    <?= $supervisor->getSupervisor()->getNombres() . " " . $supervisor->getSupervisor()->getApellidos() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span id="error-supervisor" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>
                        <span id="error-inicio" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="fecha_cierre">Fecha Cierre</label>
                        <input type="datetime-local" id="fecha_cierre" name="fecha_cierre" required readonly>
                        <span id="error-cierre" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="total_turnos">Total Turnos</label>
                        <input type="number" id="total_turnos" name="total_turnos" required>
                        <span id="error-turnos" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Crear Atencion" id="button-create">
                    </div>


                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../Js/createatencion.js"></script>
    <script src="../Js/index.js"></script>
    <script src="../Js/alert.js"></script>
    <script src="../Js/atenciones.js"></script>
</body>

</html>
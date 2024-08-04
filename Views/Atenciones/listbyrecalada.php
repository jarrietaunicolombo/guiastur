<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaResponse.php";

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
$atencionesResponse = @$_SESSION[ItemsInSessionEnum::LIST_ATENCIONES] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
$currentPage = $_SESSION[ItemsInSessionEnum::CURRENT_PAGE] ?? "menu";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/atenciones.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
    <div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Reporte de Atenciones
    </div>
    <?php
    $baseUrl = UrlHelper::getUrlBase();
    ?>

    <div class="menu" id="menu">
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="<?= $baseUrl ?>/Views/Users/index.php?action=menu">Usuarios</a>
        <a href="<?= $baseUrl ?>/Views/Buques/index.php?action=menu">Buques</a>
        <a href="<?= $baseUrl ?>/Views/Recaladas/index.php?action=menu">Recaladas</a>
        <a href="<?= $baseUrl ?>/Views/Atenciones/index.php?action=menu">Atenciones</a>
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=menu">Turnos</a>
        <a href="<?= $baseUrl ?>/Views/Paises/index.php?action=menu">Paises</a>
        <a href="<?= $baseUrl ?>/Views/Users/index.php?action=logout">Login</a>
    </div>
    <div class="icon-bar">
        <a href="<?= $baseUrl ?>/Views/Atenciones/index.php?action=menu"> <img
                src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
            <a
                href="<?= $baseUrl ?>/Views/Atenciones/index.php?action=create&buque=<?= @$_GET["buque"] ?>&recalada=<?= @$_GET["recalada"] ?>">
                <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add"></a>
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
    </div>
    <?php if ($errorMessage): ?>
        <script type="text/javascript">
            window.onload = function () {
                let url = "<?= $baseUrl ?>/Views/Atenciones/index.php?action=menu";
                let message = "<?= $errorMessage; ?>";
                showSimpleAlert("error", "", message, url);
            };
        </script>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <span class="message success"><?= $infoMessage; ?></span>
        <script type="text/javascript">
            window.onload = function () {
                let message = "<?= $infoMessage; ?>";
                showSimpleAlert("info", "", message );
            };
        </script>
    <?php endif; ?>
    <?php if (!($errorMessage) && $atencionesResponse === null || @count($atencionesResponse->getAtenciones()) < 1): ?>
        <script type="text/javascript">
            window.onload = function () {
                let message = "No existen atenciones para esta recalada";
                let urlOk = "<?= $baseUrl ?>/Views/Atenciones/index.php?action=create&buque=<?= @$_GET["buque"] ?>&recalada=<?= @$_GET["recalada"] ?>";
                let urlNo = "<?= $baseUrl ?>/Views/Recaladas/index.php?action=<?= @$currentPage ?>&buque=<?= @$_GET["buque"] ?>";
                let title = "";
                showConfirmAlert(title, message, "Crear Atencion", "Regresar", urlOk, urlNo);
            };
        </script>
    <?php else:
        $buque = $atencionesResponse->getBuque();
        $recalada = $atencionesResponse->getRecalada();
        $atenciones = $atencionesResponse->getAtenciones();
        ?>
        <div class="sub-header">
            <span>Buque: <?= $buque->getNombre() ?></span>
            <span>Recalada ID: <?= $recalada->getId() ?></span>
            <span>País: <?= $recalada->getPais() ?></span>
        </div>
        <div class="container">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Inicio</th>
                            <th>Cierre</th>
                            <th>Turnos</th>
                            <th>Turnos Creados</th>
                            <th>Turnos Disponibles</th>
                            <th>Supervisor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($atenciones as $atencionDto):
                            ?>
                            <tr>
                                <td><?= $atencionDto->getId() ?></td>
                                <td><?= $atencionDto->getFechaInicio()->format("Y-m-d H:i:s") ?></td>
                                <td><?= $atencionDto->getFechaCierre()->format("Y-m-d H:i:s") ?></td>
                                <td><?= $atencionDto->getTotalTurnos() ?></td>
                                <td>
                                    <a href="../Turnos/index.php?action=listbyatencion&atencion=<?= $atencionDto->getId() ?>"><?= $atencionDto->getTotalTurnosCreados() ?>
                                    </a>

                                </td>
                                <td><?= $atencionDto->getTurnosDisponibles() ?></td>
                                <td><?= $atencionDto->getSupervisorNombre() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../Js/alert.js"></script>
    <script src="../Js/index.js"></script>
</body>

</html>
<?php
// SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_ATENCIONES);
;
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
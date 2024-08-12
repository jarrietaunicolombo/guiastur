<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetBuques/Dto/GetBuquesResponse.php";
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
$buquesResponse = @$_SESSION[ItemsInSessionEnum::LIST_BUQUES] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Buque</title>
    <link rel="stylesheet" href="../Css/listbuque.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
<div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Reporte de Buque
    </div>
    <?php require_once "../menu.php" ?>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=menu"> <img
                src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home"></a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=create"> <img
                src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add"></a>
        <a href="#"> <img
                src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search"></a>
                <a href="#"><img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check"></a>
                <a href="#"> <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete"></a>
    </div>
    <?php if ($errorMessage): ?>
        <script type="text/javascript">
            window.onload = function () {
                showSimpleAlert("error", "", "<?= $errorMessage; ?>");
            };
        </script>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <span class="message success"><?= $infoMessage; ?></span>
        <script type="text/javascript">
            window.onload = function () {
                showSimpleAlert("info", "", "<?= $infoMessage; ?>");
            };
        </script>
    <?php endif; ?>
    <?php if ($buquesResponse === null || @count($buquesResponse->getBuques()) < 1): ?>
        <script type="text/javascript">
            window.onload = function () {
                let message = "No hay buques disponibles. Menu/Buques/Crear Buque"
                let urlOk = <?= UrlHelper::getUrlBase()."/Views/Buques/index.php?action=create"; ?>
                showConfirmAlert("", message, 'Crear Buque', "Cancelar", urlOk, null);
            };
        </script>
    <?php else: ?>
    <div class="container">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <!-- <th>FOTO</th> -->
                            <th>RECALADAS</th>
                            <th>ATENCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buquesResponse->getBuques() as $buque): ?>
                            <tr>
                                <td><?= $buque->getId(); ?></td>
                                <td><?= $buque->getCodigo(); ?></td>
                                <td><?= $buque->getNombre(); ?></td>
                                <!-- <td>
                                    <?php if ($buque->getFoto()): ?>
                                        <img src="<?php echo $buque->getFoto(); ?>" alt="Foto del Buque" class="photo">
                                    <?php else: ?>
                                        No disponible
                                    <?php endif; ?>
                                </td> -->
                                <td>
                                    <a
                                        href="../Recaladas/index.php?action=listbybuque&buque=<?= $buque->getId() ?>"><?= $buque->getTotalRecaladas() ?></a>
                                </td>
                                <td><?= $buque->getTotalAtenciones() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../Js/index.js"></script>
    <script src="../Js/alert.js"></script>
   
</body>

</html>

<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
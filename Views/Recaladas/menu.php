<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
SessionUtility::startSession();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos Para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
    <div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Menú para Recaladas
    </div>
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
    $baseUrl = UrlHelper::getUrlBase();
    ?>
    <div class="hamburger" id="hamburger"></div>
    <div class="menu" id="menu">
        <a href="<?= $baseUrl ?>/Views/Recaladas/index.php?action=create">Crear Recalada</a>
        <a href="<?= $baseUrl ?>/Views/Recaladas/index.php?action=listall">Ver todas las Recaladas</a>
        <a href="<?= $baseUrl ?>/Views/Recaladas/index.php?action=listinport">Ver Recaladas en el Puerto</a>
        <a href="../index.php">Menu Principal</a>
    </div>
    <script src="../Js/index.js"></script>
</body>

</html>

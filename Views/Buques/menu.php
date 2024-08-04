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
        Menú para Buques
    </div>
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
    $baseUrl = UrlHelper::getUrlBase();
    ?>
    <div class="hamburger" id="hamburger"></div>
    <div class="menu" id="menu">
        <a href="<?= $baseUrl ?>/Views/Buques/index.php?action=create">Crear</a>
        <a href="#">Buscar</a>
        <a href="#">Editar</a>
        <a href="#">Eliminar</a>
        <a href="<?= $baseUrl ?>/Views/Buques/index.php?action=listall">Ver todos</a>
        <a href="<?= $baseUrl ?>/Views/index.php">Menu principal</a>
    </div>
    <script src="../Js/index.js"></script>
</body>

</html>
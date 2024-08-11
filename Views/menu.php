<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
$baseUrl = UrlHelper::getUrlBase();
?>
<div class="menu" id="menu">
    <a href="#"></a>
    <a href="#"></a>
    <a href="#"></a>
    <a href="<?= $baseUrl ?>/Views/Users/index.php?action=menu">Usuarios</a>
    <a href="<?= $baseUrl ?>/Views/Buques/index.php?action=menu">Buques</a>
    <a href="<?= $baseUrl ?>/Views/Recaladas/index.php?action=menu">Recaladas</a>
    <a href="<?= $baseUrl ?>/Views/Atenciones/index.php?action=menu">Atenciones</a>
    <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=menu">Turnos</a>
    <a href="<?= $baseUrl ?>/Views/Users/index.php?action=logout">Salir</a>
</div>
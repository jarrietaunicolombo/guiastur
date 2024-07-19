<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
SessionUtility::startSession();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bienvenido</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <style>
        .menu {
            margin: 20px 0;
        }

        .menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
            background-color: #f2f2f2;
            margin: 2px 0;
        }

        .menu a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>

    <h2><?= @$_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?></h2>

    <h3>Menú Turnos</h3>
    <div class="menu">
        <a href="">Crear</a>
        <!-- <a href="index.php">Buscar</a> -->
        <!-- <a href="index.php?action=listall">Mostrar todas</a> -->
        <a href="index.php?action=listnextall">Turnos Siguientes</a>
        <a href="index.php?action=usedtoday">Turnos en uso</a>
        <a href="index.php?action=releasedtoday">Turnos  Librados</a>
        <a href="index.php?action=finalizedtoday">Turnos Finalizados</a>
        <!-- <a href="index.php">Editar</a> -->
        <a href="../index.php">Menu Principal</a>
    </div>

</body>

</html>
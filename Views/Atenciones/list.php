<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaResponse.php";

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
$atencionesResponse = @$_SESSION[ItemsInSessionEnum::LIST_ATENCIONES] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones de la recalada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            font-size: 24px;
        }

        .icon-bar {
            width: 100%;
            background-color: #e2e2e2;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            top: 50px;
            /* Adjusted to be below the header */
            left: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 2px -2px gray;
            /* Add shadow for elegance */
        }

        .icon-bar img {
            width: 32px;
            height: 32px;
            cursor: pointer;
        }

        .sub-header {
            width: 100%;
            background-color: #e2e2e2;
            color: #333;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            top: 100px;
            /* Adjusted to be below the icon-bar */
            left: 0;
            z-index: 998;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            font-size: 18px;
            box-shadow: 0 4px 2px -2px gray;
            /* Add shadow for elegance */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 140px 20px 20px;
            /* Adjusted padding for spacing below headers */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table-container {
            position: relative;
            margin-top: 10px;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        .table-container th {
            background-color: #f4f4f4;
            position: sticky;
            top: 130px;
            /* Se ajusta para estar justo debajo del sub-header */
            z-index: 997;
        }

        .table-container td {
            background-color: #fff;
        }

        .table-container::-webkit-scrollbar {
            width: 0;
            height: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        Atenciones de la recalada Id:
        <?= isset($atencionesResponse) && @count($atencionesResponse->getAtenciones()) > 0 ? $atencionesResponse->getRecalada()->getId() : "No existe" ?>
    </div>
    <div class="icon-bar">
        <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
    </div>
    <?php if ($errorMessage): ?>
        <div> <span class="message error"><?= $errorMessage; ?></span></div>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <span class="message success"><?= $infoMessage; ?></span>
    <?php endif; ?>
    <?php if (!($errorMessage) && $atencionesResponse === null || @count($atencionesResponse->getAtenciones()) < 1): ?>
        <script type="text/javascript">
        window.onload = function() {
            showAlert("error", "", "No existen atenciones para esta recalada");
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
    <script>
    
           
            function showAlert(icon, title, message) {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: message,
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#molda-myModal').hide();
                        window.location.href = '<?= UrlHelper::getUrlBase()?>/Views/Atenciones/index.php?action=menu';
                    }
                });
            }
    
    </script>
</body>

</html>
<?php
// SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_ATENCIONES);
;
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
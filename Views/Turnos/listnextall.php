<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoResponse.php";

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
$turnosResponse = @$_SESSION[ItemsInSessionEnum::LIST_TURNOS] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Buque</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 80px 20px 20px;
            /* Adjusted padding for spacing below header */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
            /* Adjusted margin for closer spacing */
        }

        .message {
            padding: 10px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
        }

        .message.error {
            color: #d8000c;
            background-color: #ffbaba;
            border: 1px solid #d8000c;
        }

        .message.success {
            color: #4F8A10;
            background-color: #DFF2BF;
            border: 1px solid #4F8A10;
        }

        .table-container {
            position: relative;
            max-height: 400px;
            overflow-y: auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table-container th {
            background-color: #f4f4f4;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .table-container td {
            background-color: #fff;
        }

        .table-container::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .photo {
            max-width: 200px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Proximos Turnos</h1>
    </div>
    <div class="container">
        <?php if ($errorMessage): ?>
            <span class="message error"><?= $errorMessage; ?></span>
        <?php endif; ?>
        <?php if ($infoMessage): ?>
            <span class="message success"><?= $infoMessage; ?></span>
        <?php endif; ?>
        <?php if ($turnosResponse === null || count($turnosResponse) < 1): ?>
            <span class="message error">No existen Proximos turnos disponibles por ahora</span>
        <?php else:

            ?>
            <div class="table-container">
                <table>
                    <tr>
                        <th colspan="2">TURNO</th>
                        <th colspan="4">GUIA</th>
                        <th colspan="4">ATENCION</th>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>NUMERO</th>
                        <!-- <th>USADO ID</th>  -->
                        <!-- <th>REGISTRÓ USO</th>  -->
                        <!-- <th>SALIDA</th>  -->
                        <!-- <th>REGISTRÓ LA SALIDA</th>  -->
                        <!-- <th>REGRESO</th>  -->
                        <!-- <th>REGISTRÓ EL REGRESO</th>  -->
                        <!-- <th>OBSERVACIONES</th>  -->
                        <th>CEDULA</th>
                        <th>RNT</th>
                        <th>NOMBRE</th>
                        <th>TELEFONO</th>
                        <!-- <th>FOTO</th>  -->
                        <th>ID</th>
                        <th>INICIO</th>
                        <th>CIERRE</th>
                        <th>TURNOS</th>
                    </tr>
                    <?php
                    foreach ($turnosResponse as $turno):
                        $fechaInicio = (@$turno->getAtencion()->getFechaInicio() !== null) ? $turno->getAtencion()->getFechaInicio()->format("Y-m-d H:i:s") : "";
                        $fechaCierre = (@$turno->getAtencion()->getFechaCierre() !== null) ? $turno->getAtencion()->getFechaCierre()->format("Y-m-d H:i:s") : "";
                        ?>
                        <TR>
                            <TD><?= $turno->getId() ?> </td>
                            <TD><?= $turno->getNumero() ?> </td>
                            <!-- <TD><?= $turno->getFechaUso() !== null ? $turno->getFechaUso()->format("Y-m-d H:i:s") : "" ?> </td> -->
                            <!-- <TD><?= $turno->getUsuarioUso() ?> </td> -->
                            <!-- <TD><?= $turno->getFechaSalida() !== null ? $turno->getFechaSalida()->format("Y-m-d H:i:s") : "" ?> </td> -->
                            <!-- <TD><?= $turno->getUsuarioUso() ?> </td> -->
                            <!-- <TD><?= $turno->getFechaRegreso() !== null ? $turno->getFechaRegreso()->format("Y-m-d H:i:s") : "" ?> </td> -->
                            <!-- <TD><?= $turno->getUsuarioUso() ?> </td> -->
                            <!-- <TD><?= $turno->getObservaciones() ?> </td> -->
                            <TD><?= $turno->getGuia()->getCedula() ?> </td>
                            <TD><?= $turno->getGuia()->getRnt() ?> </td>
                            <TD><?= $turno->getGuia()->getNombre() ?> </td>
                            <TD><?= $turno->getGuia()->getTelefono() ?> </td>
                            <!-- <TD><?= $turno->getGuia()->getFoto() ?> </td> -->
                            <TD><?= $turno->getAtencion()->getId() ?> </td>
                            <TD><?= $fechaInicio ?> </td>
                            <TD><?= $fechaCierre ?> </td>
                            <TD><?= $turno->getAtencion()->getTotalTurnos() ?> </td>
                        </TR>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
// SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_TURNOS);
;
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
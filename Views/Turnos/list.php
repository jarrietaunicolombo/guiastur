<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionResponse.php";

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
        <h1>Turno Por Atencion </h1>
    </div>
    <div class="container">
        <?php if ($errorMessage): ?>
            <span class="message error"><?=  $errorMessage; ?></span>
        <?php endif; ?>
        <?php if ($infoMessage): ?>
            <span class="message success"><?= $infoMessage; ?></span>
        <?php endif; ?>
        <?php if ($turnosResponse === null || count($turnosResponse->getTurnos()) < 1): ?>
            <span class="message error">No existe informacion sobre Atenciones para este Recalada</span>
        <?php else: 
            $atencionId = $turnosResponse->getAtencionId();
            $totalTurnos = $turnosResponse->getTotalTurnos();
            $turnosAsignados = $turnosResponse->getTurnosAsignados();
            $turnosCreados = $turnosResponse->getTurnosCreados();
            $turnosUsados = $turnosResponse->getTurnosUsados();
            $turnosLiberados = $turnosResponse->getTurnosLiberados();
            $turnosFinalizados = $turnosResponse->getTurnosFinalizados();
            $turnos = $turnosResponse->getTurnos();
            ?>
            <div class="table-container">
            <table> 
            <tr style="text-align: center;"> 
                    <th style="text-align: center;" rowspan = 2>ATENCION</th> 
                    <th style="text-align: center;" colspan="6">TURNOS</th> 
                </tr>
                <tr style="text-align: center;"> 
                    <th>ASIGNADOS</th> 
                    <th>DISPONBLES</th> 
                    <th>CREADOS</th> 
                    <th>USADOS</th> 
                    <th>LIBERADOS</th> 
                    <th>FINALIZADOS</th> 
                </tr>
     
                    <td style="text-align: center;"><?= $atencionId ?></td> 
                    <td style="text-align: center;"><?= $turnosAsignados ?></td> 
                    <td style="text-align: center;"><?= $totalTurnos - $turnosAsignados ?></td> 
                    <td style="text-align: center;"><?= $turnosCreados ?></td> 
                    <td style="text-align: center;"><?= $turnosUsados ?></td> 
                    <td style="text-align: center;"><?= $turnosLiberados ?></td> 
                    <td style="text-align: center;"><?= $turnosFinalizados ?></td> 
                 </tr>
          </table>
        <table> 
            <tr> 
                <th>ID</th> 
                <th>NUMERO</th> 
                <th>GUIA</th> 
                <th>ESTADO</th> 
                <th>USADO</th> 
                <th>LIBERADO</th> 
                <th>FINALIZADO</th> 
      
            </tr>
          <?php
                foreach ($turnos as $turnoDto):
                    $fechaUso =  (@$turnoDto->getFechaUso() !== null)? $turnoDto->getFechaUso()->format("Y-m-d H:i:s") : "";
                    $fechaSalida =   (@$turnoDto->getFechaSalida()!== null)? $turnoDto->getFechaSalida()->format("Y-m-d H:i:s") : "";
                    $fechaRegreso =  (@$turnoDto->getFechaRegreso()!== null)? $turnoDto->getFechaRegreso()->format("Y-m-d H:i:s") : "";
            ?>
            <tr>
                <td><?= $turnoDto->getId() ?></td> 
                <td><?= $turnoDto->getNumero() ?></td> 
                <td><?= $turnoDto->getGuiaNombres() ?></td> 
                <td><?= $turnoDto->getEstado() ?></td> 
                <?php $title =  empty($fechaUso)? "Turno sin usar" :  "Uso registrado por Usuario ID: ".$turnoDto->getUsuarioUso(); ?>
                <td title = "<?= $title ?>" ><?= $fechaUso?></td> 
                <?php $title =  empty($fechaSalida)? "Turno sin liberar" :  "Liberacion registrada por Usuario ID: ".$turnoDto->getUsuarioSalida(); ?>
                <td title = "<?= $title ?>" ><?= $fechaSalida ?></td> 
                <?php $title =  empty($fechaRegreso)? "Turno sin terminar" :  "Terminacion registrada por Usuario ID: ".$turnoDto->getUsuarioRegreso(); ?>
                <td title = "<?= $title ?>" ><?=  $fechaRegreso ?></td> 
            </tr>
        <?php endforeach; ?>
        </table>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
// SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_ATENCIONES);
;
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
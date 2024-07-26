<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladasInThePort/Dto/GetRecaladasInThePortResponse.php";

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
$recaladasResponse = @$_SESSION[ItemsInSessionEnum::LIST_RECALADAS] ?? null;
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
            padding: 8px 12px;
            margin: 10px 0;
            border-radius: 3px;
            font-weight: 500;
        }

        .message.error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .message.success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
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
        <h1>Recaladas en el puerto</h1>
    </div>
    <div class="container">
        <?php if ($errorMessage): ?>
            <span class="message error"><?php echo $errorMessage; ?></span>
        <?php endif; ?>
        <?php if ($infoMessage): ?>
            <span class="message success"><?php echo $infoMessage; ?></span>
        <?php endif; ?>
        <?php if ($recaladasResponse === null || @count($recaladasResponse->getRecaladas()) < 1): ?>
            <span class="message error">No existe informacion sobre Recaladas</span>

        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>BUQUE</th>
                            <th>ARRIBO</th>
                            <th>ZARPE</th>
                            <th>TURISTAS</th>
                            <th>PAIS</th>
                            <th>ATENCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recaladasResponse->getRecaladas() as $recalada): ?>
                            <tr>
                                <td><?= $recalada->getRecaladaId(); ?></td>
                                <td><?= $recalada->getBuqueNombre(); ?></td>
                                <td><?= $recalada->getFechaArribo()->format("Y-m-d H:i:s"); ?></td>
                                <td><?= $recalada->getFechaZarpe()->format("Y-m-d H:i:s"); ?></td>
                                <td><?= $recalada->getTotalTuristas(); ?></td>
                                <td><?= $recalada->getPaisNombre(); ?></td>
                                <td>
                                    <a
                                        href="../Atenciones/index.php?action=listbyrecalada&page=listinport&recalada=<?= $recalada->getRecaladaId() ?>"><?= $recalada->getNumeroAtenciones() ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
// SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_RECALADAS);
;
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
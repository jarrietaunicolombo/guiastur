<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtenciones/Dto/GetAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionResponse.php";

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
$atencionResponse = @$_SESSION[ItemsInSessionEnum::FOUND_ATENCION] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? null;
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? null;
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
        Turnos de Atencion Id:
        <?= $atencionResponse !== null ? $atencionResponse->getAtencionId() : "---" ?>
    </div>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Atenciones/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home"></a>
        <a href="#">
            <img id="create" src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png"
                alt="Add"></a>
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
    </div>
    <?php if ($errorMessage): ?>
        <script type="text/javascript">
            window.onload = function () {
                showAlert("error", "", "<?= $errorMessage; ?>", false);
            };
        </script>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <span class="message success"><?= $infoMessage; ?></span>
        <script type="text/javascript">
            window.onload = function () {
                showAlert("info", "", "<?= $infoMessage; ?>", false);
            };
        </script>
    <?php endif; ?>

    <?php if ($turnosResponse === null || @count($turnosResponse->getTurnos()) < 1): ?>
        <script type="text/javascript">
            window.onload = function () {
                showAlert("error", "", "No existen turnos para esta atencion", true);
            };
        </script>
    <?php else:
        $buque = $atencionResponse->getBuque();
        $recalada = $atencionResponse->getRecalada();
        ?>
        <div class="sub-header">
            <span>Buque: <?= $buque->getNombre() ?></span>
            <span>Recalada ID: <?= $recalada->getId() ?></span>
            <span>Inicio: <?= $atencionResponse->getFechaInicio()->format("Y-m-d H:i:s") ?></span>
            <span>Cierre: <?= $atencionResponse->getFechaCierre()->format("Y-m-d H:i:s") ?></span>
        </div>
        <div class="container">
            <div class="table-container">
                <?php
                $atencionId = $atencionResponse->getAtencionId();
                $totalTurnos = $turnosResponse->getTotalTurnos();
                $turnosAsignados = $turnosResponse->getTurnosAsignados();
                $turnosCreados = $turnosResponse->getTurnosCreados();
                $turnosUsados = $turnosResponse->getTurnosUsados();
                $turnosLiberados = $turnosResponse->getTurnosLiberados();
                $turnosFinalizados = $turnosResponse->getTurnosFinalizados();
                $turnos = $turnosResponse->getTurnos();
                ?>

                <table>
                    <tr style="text-align: center;">
                        <th style="text-align: center;" rowspan=2>ATENCION</th>
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
                        $fechaUso = (@$turnoDto->getFechaUso() !== null) ? $turnoDto->getFechaUso()->format("Y-m-d H:i:s") : "";
                        $fechaSalida = (@$turnoDto->getFechaSalida() !== null) ? $turnoDto->getFechaSalida()->format("Y-m-d H:i:s") : "";
                        $fechaRegreso = (@$turnoDto->getFechaRegreso() !== null) ? $turnoDto->getFechaRegreso()->format("Y-m-d H:i:s") : "";
                        ?>
                        <tr>
                            <td><?= $turnoDto->getId() ?></td>
                            <td><?= $turnoDto->getNumero() ?></td>
                            <td><?= $turnoDto->getGuiaNombres() ?></td>
                            <td><?= $turnoDto->getEstado() ?></td>
                            <?php $title = empty($fechaUso) ? "Turno sin usar" : "Uso registrado por Usuario ID: " . $turnoDto->getUsuarioUso(); ?>
                            <td title="<?= $title ?>"><?= $fechaUso ?></td>
                            <?php $title = empty($fechaSalida) ? "Turno sin liberar" : "Liberacion registrada por Usuario ID: " . $turnoDto->getUsuarioSalida(); ?>
                            <td title="<?= $title ?>"><?= $fechaSalida ?></td>
                            <?php $title = empty($fechaRegreso) ? "Turno sin terminar" : "Terminacion registrada por Usuario ID: " . $turnoDto->getUsuarioRegreso(); ?>
                            <td title="<?= $title ?>"><?= $fechaRegreso ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

        function showAlert(icon, title, message, confirm = false) {
            let messageCreate = "Crear atencion";
            let messageNo = "Regresar";
            let messageOk = message;
            Swal.fire({
                icon: icon,
                title: title,
                text: message,
                showCancelButton: confirm,
                confirmButtonText: (!confirm) ? messageOk : messageCreate,
                cancelButtonText: messageNo,
            }).then((result) => {
                if (icon === "info") {
                    $('#molda-myModal').hide();
                }
                else
                    if (result.isConfirmed) {
                        createTurno();
                    }
                    else {
                        window.location.href = '<?= UrlHelper::getUrlBase() ?>/Views/Atenciones/index.php?action=listbyrecalada&recalada=<?= $atencionResponse->getRecalada()->getId() ?>';
                    }
            });
        }


        $(document).ready(function () {
            $("#create").on("click", function (event) {
                event.preventDefault();
                // Muestra la ventana de confirmación
                Swal.fire({
                    title: "¿Deseas tomar un turno para esta Recalada?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Sí",
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario dice "Sí", realiza la petición
                        createTurno();
                    }
                });
            });
        });

        function createTurno() {
            $.ajax({
                url: "<?= UrlHelper::getUrlBase() ?>/Views/Turnos/index.php?action=create",
                type: "POST",
                dataType: 'json',

                success: function (response) {
                    // Maneja la respuesta si es necesario
                    if (response.id) {
                        Swal.close();
                        const message = "Su turno es #" + response.id;
                        Swal.fire({
                            title: "",
                            text: message,
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "Sí",
                            cancelButtonText: "No"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Si el usuario dice "Sí", realiza la petición
                                window.location.href = '<?= UrlHelper::getUrlBase() ?>/Views/Turnos/index.php?action=listbyatencion&atencion=<?= $atencionResponse->getAtencionId() ?>';
                            }
                        });
                    }
                    else if (response.error) {
                        Swal.close();
                        const message = response.error;
                        Swal.fire({
                            title: "",
                            text: message,
                            icon: "error"
                        });

                    }
                },
                error: function (error) {
                    Swal.close();
                    const message = "Ocurrio un error desconicodo";
                    Swal.fire({
                        title: "",
                        text: message,
                        icon: "error"
                    });
                }
            });
        }

    </script>
</body>

</html>
<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_TURNOS);
?>
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
    <title>Control de Turnos para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/atenciones.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
    <div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
       Turnos de Atencion Id: <?= $atencionResponse !== null ? $atencionResponse->getAtencionId() : "---" ?>
    </div>
    <?php
    $baseUrl = UrlHelper::getUrlBase();
    ?>

    <div class="menu" id="menu">
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="<?= $baseUrl ?>/Views/Users/index.php?action=menu">Usuarios</a>
        <a href="<?= $baseUrl ?>/Views/Buques/index.php?action=menu">Buques</a>
        <a href="<?= $baseUrl ?>/Views/Recaladas/index.php?action=menu">Recaladas</a>
        <a href="<?= $baseUrl ?>/Views/Atenciones/index.php?action=menu">Atenciones</a>
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=menu">Turnos</a>
        <a href="<?= $baseUrl ?>/Views/Paises/index.php?action=menu">Paises</a>
        <a href="<?= $baseUrl ?>/Views/Users/index.php?action=logout">Login</a>
    </div>

    <div class="icon-bar">
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=menu"> 
            <img src="<?= $baseUrl ?>/Views/Img/menu.png" alt="Menú">
        </a> &nbsp;&nbsp;
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=listnextall"> 
            <img src="<?= $baseUrl ?>/Views/Img/turnosiguientes48px.png" title="Proximos Turnos" alt="Proximos Turnos">
        </a>&nbsp;&nbsp;
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=usedtoday"> 
            <img src="<?= $baseUrl ?>/Views/Img/turnoenuso48px.png" title="Turnos en Uso" alt="Turnos en uso">
        </a>&nbsp;&nbsp;
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=releasedtoday">
            <img src="<?= $baseUrl ?>/Views/Img/turnoliberado48px.png" title="Turnos Liberados" alt="Turlos liberados">
        </a> &nbsp;&nbsp;
        <a href="<?= $baseUrl ?>/Views/Turnos/index.php?action=finishedtoday"> 
            <img src="<?= $baseUrl ?>/Views/Img/turnofinalizado48px.png" alt="Turnos finalizados">
        </a>
    </div>

    <?php if ($errorMessage): ?>
        <script type="text/javascript">
            window.onload = function () {
                <?php $urlAtencion = $baseUrl."/Views/Atenciones/index.php?action=listbyrecalada&recalada=". $atencionResponse->getRecalada()->getId() ; ?>
                showSimpleAlert("error", "", "<?= $errorMessage; ?>", "<?=  $urlAtencion ?>");
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

    <?php if ($turnosResponse === null || @count($turnosResponse->getTurnos()) < 1): ?>
        <script type="text/javascript">
            window.onload = function () {
                <?php $urlAtencion = $baseUrl."/Views/Atenciones/index.php?action=listbyrecalada&recalada=". $atencionResponse->getRecalada()->getId() ; ?>
                <?php $urlCreateTurno = $baseUrl."/Views/Turnos/index.php?action=create"; ?>
                <?php $urlTurnos = $baseUrl."/Views/Turnos/index.php?action=listbyatencion&atencion=".$atencionResponse->getAtencionId(); ?>
                showAlert("error", "", "No existen turnos para esta atencion", true,  "<?= $urlCreateTurno; ?>", "<?= $urlTurnos; ?>", "<?= $urlAtencion; ?>");
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
    <script src="../Js/alert.js"></script>
    <script src="../Js/createturno.js"></script>
    <script src="../Js/index.js"></script>
    <script>
        $(document).ready(function () {
            $("#create").on("click", function (event) {
                event.preventDefault();
                // Muestra la ventana de confirmación
                Swal.fire({
                    title: "¿Deseas tomar un turno para esta Atencion?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Sí",
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        <?php $urlCreateTurno =  $baseUrl."/Views/Turnos/index.php?action=create"; ?>
                        <?php $urlTurnos = $baseUrl."/Views/Turnos/index.php?action=listbyatencion&atencion=".$atencionResponse->getAtencionId(); ?>
                        // Si el usuario dice "Sí", realiza la petición
                        createTurno("<?= $urlCreateTurno?>", "<?= $urlTurnos?>");
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_TURNOS);
?>
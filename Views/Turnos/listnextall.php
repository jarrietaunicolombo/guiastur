<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoResponse.php";

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
$turnosResponse = @$_SESSION[ItemsInSessionEnum::LIST_NEXT_TURNOS_BY_STATUS] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/turnostep.css">
</head>
<?php $baseUrl = UrlHelper::getUrlBase(); ?>
<body>
    <div class="header">
        Proximos Turnos
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
                showSimpleAlert("error", "", "<?= $errorMessage ?>");
            };
        </script>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <script type="text/javascript">
            window.onload = function () {
                showSimpleAlert("info", "", "<?= $infoMessage ?>");
            };
        </script>
    <?php endif; ?>
    <?php if (!$errorMessage && ($turnosResponse === null || @count($turnosResponse) < 1)): ?>
        <script type="text/javascript">
            window.onload = function () {
                showSimpleAlert("warning", "", "No existen turnos para usar en este momento");
            };
        </script>
    <?php endif; ?>
    <?php if ($turnosResponse !== null && @count($turnosResponse) > 0): ?>
        <div class="container">
            <div class="table-container">
                <table class="molda-table">
                    <thead>
                        <tr>
                            <th colspan="2" class="molda-th">TURNO</th>
                            <th colspan="4" class="molda-th">GUIA</th>
                            <th colspan="4" class="molda-th">ATENCION</th>
                        </tr>
                        <tr>
                            <th class="molda-th">ID</th>
                            <th class="molda-th">NUMERO</th>
                            <th class="molda-th">CEDULA</th>
                            <th class="molda-th">RNT</th>
                            <th class="molda-th">NOMBRE</th>
                            <th class="molda-th">TELEFONO</th>
                            <th class="molda-th">ID</th>
                            <th class="molda-th">INICIO</th>
                            <th class="molda-th">FIN</th>
                            <th class="molda-th">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turnosResponse as $turno):
                            $fechaInicio = (@$turno->getAtencion()->getFechaInicio() !== null) ? $turno->getAtencion()->getFechaInicio()->format("Y-m-d H:i:s") : "";
                            $fechaCierre = (@$turno->getAtencion()->getFechaCierre() !== null) ? $turno->getAtencion()->getFechaCierre()->format("Y-m-d H:i:s") : "";
                            ?>
                            <tr class="molda-row" data-id="<?= $turno->getId() ?>" data-numero="<?= $turno->getNumero() ?>"
                                data-nombre="<?= $turno->getGuia()->getNombre() ?>"
                                data-atencion="<?= $turno->getAtencion()->getId() ?>">
                                <td class="molda-td"><?= $turno->getId() ?></td>
                                <td class="molda-td"><?= $turno->getNumero() ?></td>
                                <td class="molda-td"><?= $turno->getGuia()->getCedula() ?></td>
                                <td class="molda-td"><?= $turno->getGuia()->getRnt() ?></td>
                                <td class="molda-td"><?= $turno->getGuia()->getNombre() ?></td>
                                <td class="molda-td"><?= $turno->getGuia()->getTelefono() ?></td>
                                <td class="molda-td"><?= $turno->getAtencion()->getId() ?></td>
                                <td class="molda-td"><?= $fechaInicio ?></td>
                                <td class="molda-td"><?= $fechaCierre ?></td>
                                <td class="molda-td"><?= $turno->getAtencion()->getTotalTurnos() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Modal -->
    <div id="molda-myModal" class="molda-modal">
        <div class="molda-modal-content">
            <div class="molda-modal-header">
                <span id="molda-modalGuia"></span><br>
                <span id="molda-modalTurno"></span>
            </div>
            <form id="molda-turnoForm" method="post" action="/guiastur/Views/Turnos/index.php">
                <input type="hidden" name="turnoid" id="molda-id_turno">
                <input type="hidden" name="atencionid" id="molda-id_atencion">
                <input type="hidden" name="action" id="molda-action">
                <div class="molda-form-group">
                    <label for="observaciones">Observaciones:</label>
                    <textarea id="molda-observaciones" name="observaciones" style="width: 100%; height: 60px;"></textarea>
                </div>
                <div class="molda-modal-footer">
                    <button type="button" class="molda-use">Usar Turno</button>
                    <button type="button" class="molda-cancel">Anular Turno</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        let url = '<?= UrlHelper::getUrlBase() ?>/Views/Turnos/index.php?action=listnextall';
        let turnoStatus = "<?= TurnoStatusEnum::INUSE ?>";
        let message = "El Guia ahora puede hacer uso del turno #";
        let action = "usarturno";
    </script>
    <script src="../Js/alert.js"></script>
    <script src="../Js/turnostep.js"></script>
</body>
</html>

<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>

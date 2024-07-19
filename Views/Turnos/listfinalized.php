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
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
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
            text-align: center;
        }

        .table-container th {
            background-color: #f4f4f4;
            position: sticky;
            top: 0;
            z-index: 2;
            text-align: center;
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

        .molda-body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .molda-header {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .molda-table-container {
            margin-top: 20px;
        }

        .molda-table {
            width: 100%;
            border-collapse: collapse;
        }

        .molda-table,
        .molda-th,
        .molda-td {
            border: 1px solid #ddd;
        }

        .molda-th,
        .molda-td {
            padding: 8px;
            text-align: center;
        }

        .molda-th {
            background-color: #f2f2f2;
        }

        /* Modal Styles */
        .molda-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .molda-modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
        }

        .molda-modal-header {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .molda-modal-footer {
            display: flex;
            justify-content: space-between;
        }

        .molda-modal-footer button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .molda-modal-footer .molda-use {
            background-color: #28a745;
            color: #fff;
        }

        .molda-modal-footer .molda-cancel {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="molda-header">
        <h1>Proximos Turnos</h1>
    </div>

    <?php if ($errorMessage): ?>
        <span class="message error"><?= $errorMessage; ?></span>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <span class="message success"><?= $infoMessage; ?></span>
    <?php endif; ?>
    <?php if ($turnosResponse === null || count($turnosResponse) < 1): ?>
        <span class="message error">No existen turnos finalizados en este momento</span>
    <?php endif; ?>
    <?php if ($turnosResponse !== null && count($turnosResponse) > 0): ?>
        <div class="molda-table-container">
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
            </table>
        </div>
    <?php endif; ?>
    </div>
    <!-- Modal -->
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
                    <textarea id="molda-observaciones" name="observaciones"
                        style="width: 100%; height: 60px;"></textarea>
                </div>
                <div class="molda-modal-footer">
                    <button type="button" class="molda-use">Use</button>
                    <button type="button" class="molda-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            var turnoNumero = 0;
            $('.molda-row').click(function () {
                var turnoId = $(this).data('id');
                 turnoNumero = $(this).data('numero');
                var guiaNombre = $(this).data('nombre');
                var atencionId = $(this).data('atencion');

                $('#molda-id_turno').val(turnoId);
                $('#molda-id_atencion').val(atencionId);
                $('#molda-modalGuia').text('GUIA: ' + guiaNombre);
                $('#molda-modalTurno').text('TURNO NUMERO: ' + turnoNumero);
                $('#molda-myModal').show();
            });

            $('.molda-use').click(function () {
                $('#molda-action').val('usarturno');
                $('#molda-turnoForm').submit();
            });

            $('.molda-cancel').click(function () {
                $('#molda-action').val('cancelarturno');
                $('#molda-turnoForm').submit();
            });

            $('#molda-turnoForm').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        $('#molda-myModal').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Turno procesado',
                            text: 'El Guia ahora puede hacer uso del turno #'.turnoNumero,
                            showCancelButton: false,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'http://localhost/guiastur/Views/Turnos/index.php?action=listnextall';
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la petición AJAX:', error);
                        alert('Error al procesar la solicitud.');
                    }
                });
            });

            // Hide modal when clicking outside of it
            $(window).click(function (event) {
                if (event.target.id === 'molda-myModal') {
                    $('#molda-myModal').hide();
                }
            });
        });
    </script>
</body>

</html>

<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
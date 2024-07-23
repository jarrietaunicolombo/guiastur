<?php
require_once '../../Controllers/SessionUtility.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';
require_once '../../Application/UseCases/GetSupervisor/Dto/GetSupervisorResponse.php';
require_once '../../Application/UseCases/GetRecaladas/GetRecaladasService.php';

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
$supervisores = @$_SESSION[ItemsInSessionEnum::LIST_SUPERVISORES];
$recalada = @$_SESSION[ItemsInSessionEnum::FOUND_RECALADA];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Crear Recalada</title>
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
            padding: 5px 0;
            /* Reducir padding para acercar al formulario */
            position: fixed;
            top: 50px;
            /* Justo debajo de la cabecera */
            left: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 2px -2px gray;
        }

        .icon-bar img {
            width: 32px;
            height: 32px;
            cursor: pointer;
        }

        .content-zone {
            margin-top: 100px;
            /* Espacio para la cabecera y la barra de íconos */
            padding: 20px;
            /* Padding alrededor de la zona de contenido */
        }

        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
        }

        .form-container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin: auto;
            overflow-y: scroll;
            /* Habilitar scroll si es necesario */
            max-height: 80vh;
            /* Altura máxima para el contenedor del formulario */
            scrollbar-width: none;
            /* Firefox */
        }

        .form-container::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari y Opera */
        }

        .form-container h2 {
            text-align: left;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-top: 5px;
        }

        .form-group textarea {
            min-height: 80px;
            /* Ajusta este valor según sea necesario */
        }

        .form-group input[type="submit"],
        .form-group button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .form-group input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            margin-right: 4%;
        }

        .form-group button {
            background-color: #dc3545;
            color: #fff;
        }

        .form-group input[type="submit"]:hover,
        .form-group button:hover {
            opacity: 0.9;
        }

        .session-data {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: left;
        }

        .session-data p {
            margin: 5px 0;
            font-size: 16px;
        }

        .session-data strong {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        Crear Atención
    </div>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Recaladas/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        </a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Recaladas/index.php?action=listall">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
        </a>
    </div>

    <div class="content-zone">
        <div class="form-wrapper">
            <div class="form-container">
                <?php if (@$supervisores === null || count(@$supervisores) < 1): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let error = "No hay supervisores disponibles. Menu/Usuarios/Crear";
                            showAlert("error", "", error, false);
                        };
                    </script>
                <?php endif; ?>
                <?php if (@$usuarioLogin === null): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let error = "No tiene permisos suficientes. Menu/Usuarios/Login";
                            showAlert("error", "", error, false);
                        };
                    </script>
                <?php endif; ?>
                <div class="session-data">
                    <p><strong>Usuario ID:</strong> <?= ($usuarioLogin) ? $usuarioLogin->getNombre() : "---" ?></p>
                    <p><strong>Recalada ID:</strong> <?= ($recalada) ? $recalada->getRecaladaId() : "---" ?></p>
                    <p><strong>Arribo:</strong>
                        <?= ($recalada) ? $recalada->getFechaArribo()->format("Y-m-d H:i:s") : "---" ?></p>
                    <p><strong>Zarpe:</strong>
                        <?= ($recalada) ? $recalada->getFechaZarpe()->format("Y-m-d H:i:s") : "---" ?></p>
                </div>
                <form action="index.php" method="POST" id="atencion-form">
                    <input type="hidden" name="action" value="create" id="action">
                    <div class="form-group">
                        <label for="supervisor_id">Supervisor:</label>
                        <select name="supervisor_id" id="supervisor_id" required>
                            <option value="" disabled selected>Seleccione uno...</option>
                            <?php foreach ($supervisores as $supervisor): ?>
                                <option value="<?= @$supervisor->getSupervisor()->getCedula() ?>"
                                    <?= (@$supervisor->getUsuario()->getId() == @$usuarioLogin->getId()) ? "selected" : "" ?>>
                                    <?= $supervisor->getSupervisor()->getNombres() . " " . $supervisor->getSupervisor()->getApellidos() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span id="error-supervisor" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>
                        <span id="error-inicio" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="fecha_cierre">Fecha Cierre</label>
                        <input type="datetime-local" id="fecha_cierre" name="fecha_cierre" required readonly>
                        <span id="error-cierre" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="total_turnos">Total Turnos</label>
                        <input type="number" id="total_turnos" name="total_turnos" required>
                        <span id="error-turnos" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Crear Atencion" id="button-create">
                    </div>


                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $('#atencion-form').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                let message = "Error desconocido";
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.id >= 1) {
                            message = 'Atecion creado con ID: ' + response.id;
                            showAlert('success', 'Éxito', message, false);
                        }
                        else if (response.error) {
                            message = response.error;
                            showAlert('error', 'Error', message, false);
                            showFormError(response);
                        }
                        else {
                            message = "Error desconocido";
                            showAlert('error', 'Error', message, false);
                        }
                    },
                    error: function (xhr, status, error) {
                        showAlert('error', 'Error', message + ": " + error);
                    }
                });
            });

            $('#fecha_inicio').on('change', function () {
                getEndDateAtencion();
            });

        });

        function showAlert(icon, title, message, confirm = false) {

            Swal.fire({
                icon: icon,
                title: title,
                text: message,
                showCancelButton: confirm,
                confirmButtonText: "OK",
                cancelButtonText: "Cancelar",
                allowOutsideClick: true,
            }).then((result) => {
                if (icon == "success") {
                    cleanForm();
                }
            });
        }

        function cleanForm() {
            $('#atencion-form')[0].reset();
        }

        function showFormError(errorMessages) {
            $("#error-supervisor").text(errorMessages.supervisor ?? '');
            $("#error-inicio").text(errorMessages.inicio ?? '');
            $("#error-cierre").text(errorMessages.cierre ?? '');
            $("#error-turnos").text(errorMessages.turnos ?? '');

        }

        function getEndDateAtencion() {
            // Obtener la fecha de inicio
            const fechaInicio = $('#fecha_inicio').val();

            if (fechaInicio) {
                const fecha = new Date(fechaInicio);
                fecha.setHours(fecha.getHours() + 1);
                // Formatear la fecha para datetime-local
                const anio = fecha.getFullYear();
                const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Mes de 1-12
                const dia = String(fecha.getDate()).padStart(2, '0'); // Día de 1-31
                const horas = String(fecha.getHours()).padStart(2, '0'); // Horas de 0-23
                const minutos = String(fecha.getMinutes()).padStart(2, '0'); // Minutos de 0-59

                const fechaFormateada = `${anio}-${mes}-${dia}T${horas}:${minutos}`;

                // Establecer la fecha resultado
                $('#fecha_cierre').val(fechaFormateada);
            }
        }

    </script>
</body>

</html>
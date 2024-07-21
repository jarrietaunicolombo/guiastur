<?php
require_once '../../Controllers/SessionUtility.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';
require_once '../../Application/UseCases/GetBuques/Dto/GetBuquesResponse.php';
require_once '../../Application/UseCases/GetPaises/Dto/GetPaisesResponse.php';

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

$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? null;
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? null;
$buquesResponse = $_SESSION[ItemsInSessionEnum::LIST_BUQUES] ?? null;
$paisesResponse = $_SESSION[ItemsInSessionEnum::LIST_PAISES] ?? null;
$erroMessages = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] ?? null;
$requestData = @$_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] ?? null;

if ($errorMessage) {
    $infoMessage = null;
} else if ($infoMessage) {
    $errorMessage = null;
}
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
    </style>
</head>

<body>

    <div class="header">
        Crear Buque
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
                <?php if (@$paisesResponse === null || count(@$paisesResponse->getPaises()) < 1): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let error = "No existen Paises disponibles. Menú Paises/Crear";
                            showAlert("error", "", error, false);
                        };
                    </script>
                <?php endif; ?>

                <?php if (@$buquesResponse !== null && count(@$buquesResponse->getBuques()) > 0 && @$paisesResponse !== null && count(@$paisesResponse->getPaises()) > 0): ?>
                    <form action="index.php" method="POST" id="recalada-form">
                        <input type="hidden" name="action" value="create" id="action">
                        <div class="form-group">
                            <label for="buque_id">Buque:</label>
                            <select name="buque_id" id="buque_id" required>
                                <option value="" disabled selected>Seleccione uno...</option>
                                <?php foreach ($buquesResponse->getBuques() as $recalada): ?>
                                    <option value="<?= @$recalada->getId() ?>"
                                        <?= (@$recalada->getId() == @$requestData["buque_id"]) ? "selected" : "" ?>>
                                        <?= $recalada->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="error-buque" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="pais_id">País:</label>
                            <select name="pais_id" id="pais_id" required>
                                <option value="" disabled selected>Seleccione uno...</option>
                                <?php foreach ($paisesResponse->getPaises() as $pais): ?>
                                    <option value="<?= @$pais->getId() ?>" <?= (@$pais->getId() == @$requestData["pais_id"]) ? "selected" : "" ?>><?= $pais->getNombre() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="error-pais" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="fecha_arribo">Fecha de Arribo:</label>
                            <input type="datetime-local" id="fecha_arribo" name="fecha_arribo" required
                                value="<?= @$requestData["fecha_arribo"] ?? "" ?>">
                            <span id="error-arribo" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="fecha_zarpe">Fecha de Zarpe:</label>
                            <input type="datetime-local" id="fecha_zarpe" name="fecha_zarpe" required
                                value="<?= @$requestData["fecha_zarpe"] ?? "" ?>">
                            <span id="error-zarpe" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="total_turistas">Total Turistas:</label>
                            <input type="number" id="total_turistas" name="total_turistas" required
                                value="<?= @$requestData["total_turistas"] ?? "" ?>">
                            <span id="error-turistas" style="color: red;"></span>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones:</label>
                            <textarea id="observaciones"
                                name="observaciones"><?= @$requestData["observaciones"] ?? "" ?></textarea>
                        </div>

                        <div class="form-group">
                            <strong>Usuario:</strong>
                            <span><?= $usuarioLogin->getNombre() ?></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Crear Recalada" id="button-create">
                            <button type="reset">Reset</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $('#recalada-form').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        let message = "Error desconocido";
                        if (response.id >= 1) {
                            message = 'Recalada creado con ID: ' + response.id;
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
               if(icon == "success"){
                 cleanForm();
               }
            });
        }

        function cleanForm(){
            $('#recalada-form')[0].reset();
        }

        function showFormError(errorMessages){
            $("#error-buque").text(errorMessages.buque ?? '');
            $("#error-pais").text(errorMessages.pais ?? '');
            $("#error-arribo").text(errorMessages.arribo ?? '');
            $("#error-zarpe").text(errorMessages.zarpe ?? '');
            $("#error-turistas").text(errorMessages.turistas ?? '');
        }

    </script>
</body>

</html>

<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGES);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::RECALADA_REQUEST_CREATING);
?>
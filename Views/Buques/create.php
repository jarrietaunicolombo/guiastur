<?php
require_once '../../Controllers/SessionUtility.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';

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

$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Buque</title>
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

        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: calc(100vh - 60px);
            margin-top: 60px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            margin: auto;
        }

        .form-container::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-top: 5px;
        }

        .form-group input[type="submit"],
        .form-group button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
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
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        </a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=listall">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        </a>
        <a href="#">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
        </a>
    </div>
    <div class="form-wrapper">
        <div class="form-container">
            <h2>Ingrese los datos del buque</h2>

            <form action="index.php" method="post" id="buque-form">
                <input type="hidden" name="action" value="create" id="action">
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" id="codigo" placeholder="El codigo del buque">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" id="nombre" required placeholder="El nombre del buque">
                </div>
                <div class="form-group">
                    <strong>Usuario:</strong>
                    <span><?= @$usuarioLogin->getNombre() ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Crear Buque" id="button-create">
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {


            $('#buque-form').submit(function (e) {
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
                            message = 'Buque creado con ID: ' + response.id;
                            showAlert('success', 'Éxito', message, false);
                            cleanForm();
                        }
                        else if (response.error) {
                            message = response.error;
                            showAlert('error', 'Error', message, false);
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

            $(window).click(function (event) {
                if (event.target.id === 'molda-myModal') {
                    $('#molda-myModal').hide();
                }
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
            }).then((result) => {
                $('#molda-myModal').hide();
            });
        }

        function cleanForm(){
            $('#buque-form')[0].reset();
        }

    </script>
</body>

</html>
<?php

SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
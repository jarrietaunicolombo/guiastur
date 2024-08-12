<?php
require_once '../../Controllers/Users/CreateUserController.php';
require_once '../../Controllers/SessionUtility.php';
require_once '../../DependencyInjection.php';
require_once '../../Application/UseCases/GetRoles/Dto/GetRolesResponse.php';

SessionUtility::startSession();
$rolesResponse = @$_SESSION[ItemsInSessionEnum::LIST_ROLES] ?? null;

$usuarioLogin = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;

if ($usuarioLogin === null) {
    $errorMessage = "Accion denegada, primero debe iniciar sesion";
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
    header('Location: login.php');
    exit;
}

$errorMessage = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? @$_GET["error"];
$infoMessage = @$_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? @$_GET["message"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos para Guias de Turismo</title>
    <link rel="stylesheet" href="../Css/createbuque.css">
    <link rel="stylesheet" href="../Css/index.css">
</head>

<body>
    <div class="header">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        Crear Usuario
    </div>
    <?php require_once "../menu.php" ?>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Users/index.php?action=menu">
            <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        </a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Users/index.php?action=create">
            <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        </a>
        <a href="#">
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
                <h2>Ingrese los datos del Usuario</h2>
                <?php if ($rolesResponse == null || @count($rolesResponse) < 1): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let error = "No existen Roles";
                            showSimpleAlert("error", "", error);
                        };
                    </script>
                <?php endif; ?>
                <?php if ($usuarioLogin == null): ?>
                    <script type="text/javascript">
                        window.onload = function () {
                            $("#button-create").prop("disabled", true);
                            let error = "No tiene permisos suficientes. Menú/login";
                            showSimpleAlert("error", "", error);
                        };
                    </script>
                <?php endif; ?>

                <form action="index.php" method="post" id="user-form">
                    <input type="hidden" name="action" value="create" id="action">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <span id="error-email" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                        <span id="error-nombre" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="rol_id">Rol:</label>
                        <select id="rol_id" name="rol_id" required>
                            <?php foreach ($rolesResponse->getRoles() as $rol): ?>
                                <option value="<?= $rol->getId() ?>"><?= $rol->getNombre() ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span id="error-rol" style="color: red;"></span>
                    </div>
                    <input type="hidden" name="usuario_registro" value="<?= @$usuarioLogin->getId() ?>">
                    <div class="form-group">
                        <input type="submit" value="Crear Usuario" id="button-create">
                    </div>
                </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../Js/index.js"></script>
    <script src="../Js/alert.js"></script>
    <script src="../Js/createusuario.js"></script>
</body>

</html>
<?php
unset($_SESSION[ItemsInSessionEnum::ERROR_MESSAGE]);
unset($_SESSION[ItemsInSessionEnum::INFO_MESSAGE]);
?>
<?php
require_once '../../Controllers/Users/CreateUserController.php';
require_once '../../Application/UseCases/Login/Dto/LoginResponse.php';
require_once '../../Controllers/Users/LoginController.php';
require_once '../../Controllers/SessionUtility.php';
require_once '../../DependencyInjection.php';
require_once '../../Application/UseCases/GetRoles/Dto/GetRolesResponse.php';

SessionUtility::startSession();

$rolesResponse = @$_SESSION[ItemsInSessionEnum::LIST_ROLES];
if (!isset($rolesResponse)) {
    $rolesResponse = DependencyInjection::getRolesServce()->getRoles();
    $_SESSION[ItemsInSessionEnum::LIST_ROLES] = $rolesResponse;
}
$usuarioLogin = @$_SESSION[ItemsInSessionEnum::USER_LOGIN];
if (!isset($usuarioLogin)) {
    $errorMessage = "Accion denegada, primero debe iniciar sesion";
    $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
    header('Location: login.php');
    exit;
}
$errorMessage = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGE];
$errorMessage = ($errorMessage) ? $errorMessage : ((@$_GET["error"]) ? $_GET["error"] : NULL);
$info_message = @$_SESSION[ItemsInSessionEnum::INFO_MESSAGE];
$info_message = ($info_message) ? $info_message : ((@$_GET["message"]) ? $_GET["message"] : NULL);
?>
<!-- /Views/Users/Create.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>

<body>
    <h2>Crear Usuario</h2>
    <?php if (isset($errorMessage)): ?>
        <div style="color: red;"><?= $errorMessage ?></div>
        <?php
        unset($_SESSION[ItemsInSessionEnum::ERROR_MESSAGE]);
    endif;
    ?>
    <?php if (isset($info_message)): ?>
        <div style="color: green;"><?= $info_message ?></div>
        <?php
        unset($_SESSION[ItemsInSessionEnum::INFO_MESSAGE]);
    endif;
    ?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="create">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="rol_id">Rol:</label>
        <select id="rol_id" name="rol_id" required>
            <?php

            foreach ($rolesResponse->getRoles() as $rol): ?>
                <option value="<?= $rol->getId() ?>"><?= $rol->getNombre() ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="usuario_registro">Usuario Registro:</label>
        <label><?= $usuarioLogin->getNombre() ?></label>
        <input type="hidden" name="usuario_registro"
            value="<?= $usuarioLogin->getId() ?>"><br>

        <button type="submit">Crear Usuario</button>
    </form>
</body>

</html>
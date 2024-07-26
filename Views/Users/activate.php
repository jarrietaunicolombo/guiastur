<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/GetUsuarioByTokenResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";

SessionUtility::startSession(); 
$erroMessage = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ;
$infoMessage = @$_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ;
$erroMessages = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] ;
$requestData = @$_SESSION[ItemsInSessionEnum::USER_REQUEST_ACTIVATING];
$userActivating = @$_SESSION[ItemsInSessionEnum::USER_ACTIVATING];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Activacion de Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
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
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: calc(100vh - 60px); /* 60px is the height of the header */
            margin-top: 60px; /* Space for the fixed header */
        }
        .form-container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            max-height: calc(100vh - 80px); /* 80px to account for padding and margin */
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE 10+ */
            margin: auto;
        }
        .form-container::-webkit-scrollbar { /* WebKit */
            width: 0;
            height: 0;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="hidden"] {
            display: none;
        }
        .form-group input[type="submit"], .form-group button {
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
    </style>
</head>
<body>

<div class="header">
    <h1>Formulario de Activacion de Cuenta</h1>
</div>

<div class="form-wrapper">
    <div class="form-container">
        <h2>Ingrese sus datos</h2>
        <span style="color: red"><?= @$erroMessage ?></span><p>
        <span style="color green"><?= @$infoMessage ?></span></p>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="activating">
            
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" readonly value="<?= isset($userActivating) ? $userActivating->getId() : "" ?>"><span style="color: red"><?= @$erroMessages["id"]?? "" ?></span>
            </div>
            <?php if ($userActivating->getRolNombre() === RolTypeEnum::GUIA || $userActivating->getRolNombre() === RolTypeEnum::SUPERVISOR ): ?>
            <div class="form-group" >
                <label for="cc">CC:</label>
                <input type="number" id="cc" name="cedula" required placeholder="Su número de cédula de ciudadanía" value="<?= @$requestData["cedula"] ?? "" ?>"><span style="color: red"><?= @$erroMessages["cedula"]?? "" ?></span>
            </div>
            <div class="form-group">
                <label for="rnt">RNT:</label>
                <input type="text" id="rnt" name="rnt" required placeholder="Su Registro Nacional de Turismo" value="<?= @$requestData["rnt"] ?? "" ?>"><span style="color: red"><?= @$erroMessages["rnt"]?? "" ?></span>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="pass">PASS:</label>
                <input type="password" id="pass" name="pass" required placeholder="Su contraseña enviada al correo" value="<?= @$requestData["pass"] ?? "" ?>"><span style="color: red"><?= @$erroMessages["pass"]?? "" ?></span>
            </div>
            <div class="form-group">
                <label for="new_pass">NUEVA PASS:</label>
                <input type="password" id="new_pass1" name="new_pass1" required placeholder="Su nueva contraseña" value="<?= @$requestData["new_pass1"] ?? "" ?>"><span style="color: red"><?= @$erroMessages["new_pass1"]?? "" ?></span>
            </div>
            <div class="form-group">
                <label for="new_pass_confirm">CONFIRMAR NUEVA PASS:</label>
                <input type="password" id="new_pass2" name="new_pass2" required placeholder="Repita su nueva contraseña" value="<?= @$requestData["new_pass2"] ?? "" ?>"><span style="color: red"><?= @$erroMessages["new_pass2"]?? "" ?></span>
            </div>
            <div class="form-group">
                <label for="rol">ROL:</label>
                <input type="text" id="rol" name="rol" readonly value="<?= isset($userActivating) ? $userActivating->getRolNombre() : "" ?>"> <span style="color: red"><?= @$erroMessages["rol"]?? "" ?></span>
            </div>
           <div class="form-group">
                <label for="nombres">NOMBRES:</label>
                <input type="text" id="nombres" name="nombres"  <?= ($userActivating->getRolNombre() !== RolTypeEnum::GUIA && $userActivating->getRolNombre() !== RolTypeEnum::SUPERVISOR )? "readonly" : "" ?> 
                value="<?= isset($userActivating) ? $userActivating->getNombre() : "" ?>"> <span style="color: red"><?= @$erroMessages["nombre"]?? "" ?></span>
            </div>
            <?php if ($userActivating->getRolNombre() === RolTypeEnum::GUIA || $userActivating->getRolNombre() === RolTypeEnum::SUPERVISOR ): ?>
          
            <div class="form-group">
                <label for="apellidos">APELLIDOS:</label>
                <input type="text" id="apellidos" name="apellidos" required placeholder="Sus apellidos" value="<?= @$requestData["apellidos"] ?? "" ?>"> <span style="color: red"><?= @$erroMessages["apellidos"]?? "" ?></span>
            </div>
            <div class="form-group">
                <label for="genero">GÉNERO:</label>
                <select id="genero" name="genero" required aria-required=""> <span style="color: red"><?= @$erroMessages["genero"]?? "" ?></span>
                    <option value="" disabled selected>Seleccione un género...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otros">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">FECHA NACIMIENTO:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?= @$requestData["fecha_nacimiento"] ?? "" ?>"> <span style="color: red"><?= @$erroMessages["fecha_nacimiento"]?? "" ?></span>
            </div>
            <div class="form-group">
                <label for="email">EMAIL:</label>
                <input type="email" id="email" name="email" readonly value="<?= isset($userActivating) ? $userActivating->getEmail() : "" ?>">
            </div>
            <div class="form-group">
                <label for="telefono">TELÉFONO:</label>
                <input type="tel" id="telefono" name="telefono" required placeholder="Su número de teléfono" value="<?= @$requestData["telefono"] ?? "" ?>"><span style="color: red"><?= @$erroMessages["telefono"]?? "" ?></span>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <input type="hidden" id="token" name="token" value="<?= isset($userActivating) ? $userActivating->getToken() :   "" ?>">
            </div>
       
            <div class="form-group">
                <input type="submit" value="Guardar">
                <button type="button" onclick="window.location.href='View/Users/index.php?action=cancel_activate';">Cancelar</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>


<?php
unset($_SESSION[ItemsInSessionEnum::ERROR_MESSAGE]);
unset($_SESSION[ItemsInSessionEnum::ERROR_MESSAGES]);
unset($_SESSION[ItemsInSessionEnum::INFO_MESSAGE]);
unset($_SESSION[ItemsInSessionEnum::USER_REQUEST_ACTIVATING]);
?>
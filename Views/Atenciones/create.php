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
$erroMessages = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] ?? null ;
$requestData = @$_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] ?? null;

if($errorMessage){
    $infoMessage = null;
}
else if($infoMessage){
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
            padding: 4%;
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
            margin-bottom: 20px;
        }

        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            margin-top: 70px;
            /* Adjusted margin-top to accommodate the fixed header */
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
            text-align: center;
        }

        .form-container::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .form-container h2 {
            text-align: left;
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            padding: 10px;
            margin-bottom: 10px ;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .message.error {
            color: #d8000c;
            background-color: #ffbaba;
            border: 1px solid #d8000c;
        }

        .message.success {
            color: #4F8A10;
            background-color: #DFF2BF;
            border: 1px solid #4F8A10;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            text-align: left;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-top: 5px;
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
            min-height: 80px; /* Adjust this value as needed */
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
        <h1>Crear Recalada</h1>
    </div>

    <div class="form-wrapper">
        <div class="form-container">
            <?php if(@$errorMessage): ?>
                <span class="message error"><?= @$errorMessage; ?></span>
            <?php endif;?>    
            <?php if(@$infoMessage): ?>
                <span class="message success"><?= @$infoMessage; ?></span>
                <?php endif;?>    
            <?php if (@$buquesResponse === null || count(@$buquesResponse->getBuques()) < 1): ?>
                <span class="message error">No existe informacion sobre buques</span>
            <?php endif; ?>
            <?php if (@$paisesResponse === null || count(@$paisesResponse->getPaises()) < 1): ?>
                <span class="message error">No existe informacion sobre paises</span>
            <?php endif; ?>

            <?php if (@$buquesResponse !== null && count(@$buquesResponse->getBuques()) > 0 && @$paisesResponse !== null && count(@$paisesResponse->getPaises()) > 0): ?>
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="form-group">
                        <label for="buque_id">Buque ID:</label>
                        <select name="buque_id" id="buque_id" required>
                            <option value="" disabled selected>Seleccione uno...</option>
                            <?php
                            $buques = $buquesResponse->getBuques();
                                foreach ($buques as $recalada):
                            ?>
                                <option value="<?= @$recalada->getId() ?>"  <?= (@$recalada->getId() == @$requestData["pais_id"])? "selected" : "" ?>><?= $recalada->getNombre() ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pais_id">País ID:</label>
                        <select name="pais_id" id="pais_id" required>
                            <option value="" disabled selected>Seleccione uno...</option>
                            <?php
                            $paises = $paisesResponse->getPaises();
                                foreach ($paises as $pais):
                            ?>
                                <option value="<?= @$pais->getId() ?>" <?= (@$pais->getId() == @$requestData["pais_id"])? "selected" : "" ?>><?= $pais->getNombre()?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_arribo">Fecha de Arribo:</label>
                        <input type="datetime-local" id="fecha_arribo" name="fecha_arribo" required value="<?= @$requestData["fecha_arribo"] ?? "" ?>"> <spans style="color: red"><?= @$erroMessages["fecha_arribo"]?? "" ?></spans>
                    </div>

                    <div class="form-group">
                        <label for="fecha_zarpe">Fecha de Zarpe:</label>
                        <input type="datetime-local" id="fecha_zarpe" name="fecha_zarpe" required  required value="<?= @$requestData["fecha_zarpe"] ?? "" ?>"> <span style="color: red"><?= @$erroMessages["fecha_zarpe"]?? "" ?></spans>
                    </div>

                    <div class="form-group">
                        <label for="total_turistas">Total Turistas:</label>
                        <input type="number" id="total_turistas" name="total_turistas" required  required value="<?= @$requestData["total_turistas"] ?? "" ?>"> <span style="color: red"><?= @$erroMessages["total_turistas"]?? "" ?></spans>
                    </div>


                    <div class="form-group">
                        <label for="observaciones">Observaciones:</label>
                        <textarea id="observaciones" name="observaciones"><?= @$requestData["observaciones"] ?? "" ?></textarea>
                    </div>

                    <div class="form-group">
                        <strong>Usuario:</strong>
                        <span><?= $usuarioLogin->getNombre() ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Crear Recalada">
                        <button type="reset">Reset</button>
                    </div>
                </form>
                <?php
            endif;
            ?>
        </div>
    </div>

</body>

</html>

<?php
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGES);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::RECALADA_REQUEST_CREATING);
?>
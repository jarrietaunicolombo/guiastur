<?php

$_SESSION['supervisor_id'] = "44332211";
$_SESSION['recalada_id'] = @$_GET["recalada"];
$_SESSION['usuario_id'] = 1;

$supervisor_id = $_SESSION['supervisor_id'];
$recalada_id = $_SESSION['recalada_id'];
$usuario_id = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Creación de Atención</title>
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
            margin-bottom: 10px;
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
            min-height: 80px;
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
        <h1>Crear Nueva Atención</h1>
    </div>

    <div class="form-wrapper">
        <div class="form-container">
            <h2>Formulario de Atención</h2>
            <div class="session-data">
                <p><strong>Supervisor ID:</strong> <?php echo htmlspecialchars($supervisor_id); ?></p>
                <p><strong>Recalada ID:</strong> <?php echo htmlspecialchars($recalada_id); ?></p>
                <p><strong>Usuario ID:</strong> <?php echo htmlspecialchars($usuario_id); ?></p>
            </div>
            <form id="atencionForm" action="/guiastur/Views/Turnos/index.php" method="post">
                <div class="form-group">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                </div>
                <div class="form-group">
                    <label for="fecha_cierre">Fecha Cierre</label>
                    <input type="date" id="fecha_cierre" name="fecha_cierre" required>
                </div>
                <div class="form-group">
                    <label for="total_turnos">Total Turnos</label>
                    <input type="number" id="total_turnos" name="total_turnos" required>
                </div>
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Crear Atención">
                    <button type="button" onclick="window.history.back()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<!-- /Views/Users/Create.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>
<body>
    <h2>Crear Usuario</h2>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?= $error ?></div>
    <?php endif; ?>
    <?php if (isset($_GET["message"])): ?>
        <div style="color: green;"><?= @$_GET["message"] ?></div>
    <?php endif; ?>
    <form action="index.php?action=create_user" method="post">
        <input type="hidden" name="action" value="create_user">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="rol_id">Rol:</label>
        <select id="rol_id" name="rol_id" required>
            <?php foreach ($roles as $rol): ?>
                <option value="<?= $rol->getId() ?>"><?= $rol->getNombre() ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="usuario_registro">Usuario Registro:</label>
        <input type="number" id="usuario_registro" name="usuario_registro" required><br>

        <button type="submit">Crear Usuario</button>
    </form>
</body>
</html>

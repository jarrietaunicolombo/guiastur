<!-- /Views/Users/show.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario Creado</title>
</head>
<body>
    <h2>Usuario Creado</h2>
    <?php if (isset($_SESSION['createUserResponse'])): 
        $usuarioResponse = $_SESSION['createUserResponse'];
        $usuarioCreated = $usuarioResponse->getUsuario();
        ?>
        <table border="4">
            <tr>
                <th>USUARIO ID</th>
                <th>NOMBRE</th>
                <th>ROL ID</th>
                <th>ROL</th>
                <th>ESTADO</th>
                <th>EMAIL</th>
                <th>TOKEN DE VALIDACION EL USO</th>
                <th>FECHA DE REGISTRO</th>
                <th>USUARIO REGISTRO</th>
            </tr>
            <tr>
                <td><?= $usuarioResponse->getId() ?></td>
                <td><?= $usuarioCreated->getNombre() ?></td>
                <td><?= $usuarioCreated->getRolId() ?></td>
                <td><?= $usuarioResponse->getRolNombre() ?></td>
                <td><?= $usuarioCreated->getEstado() ?></td>
                <td><?= $usuarioCreated->getEmail() ?></td>
                <td><?= $usuarioResponse->getValidationToken() ?></td>
                <td><?= $usuarioCreated->getFechaRegistro()->format("Y-m-d H:i:s") ?></td>
                <td><?= $usuarioCreated->getUsuarioRegistro() ?></td>
            </tr>
        </table>
    <?php endif; ?>
</body>
</html>

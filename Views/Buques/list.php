<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuques/Dto/GetBuquesResponse.php";
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
$buquesResponse = @$_SESSION[ItemsInSessionEnum::LIST_BUQUES] ?? null;
$errorMessage = $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] ?? "";
$infoMessage = $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] ?? "";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Buque</title>
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

        table-container {
            position: relative;
            margin-top: 10px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        .table-container th {
            background-color: #f4f4f4;
            position: sticky;
            top: 130px;
            /* Se ajusta para estar justo debajo del sub-header */
            z-index: 997;
        }

        .table-container td {
            background-color: #fff;
        }

        .table-container::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .message {
            padding: 10px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
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

       
    </style>
</head>

<body>
    <div class="header">
        Reporte de Buques
    </div>
    <div class="icon-bar">
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=menu"> <img
                src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home"></a>
        <a href="<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=create"> <img
                src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add"></a>
        <a href="#"> <img
                src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search"></a>
                <a href="#"><img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check"></a>
                <a href="#"> <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete"></a>
    </div>
    <?php if ($errorMessage): ?>
        <script type="text/javascript">
            window.onload = function () {
                showAlert("error", "", "<?= $errorMessage; ?>", false);
            };
        </script>
    <?php endif; ?>
    <?php if ($infoMessage): ?>
        <span class="message success"><?= $infoMessage; ?></span>
        <script type="text/javascript">
            window.onload = function () {
                showAlert("info", "", "<?= $infoMessage; ?>", false);
            };
        </script>
    <?php endif; ?>
    <?php if ($buquesResponse === null || count($buquesResponse->getBuques()) < 1): ?>
        <script type="text/javascript">
            window.onload = function () {
                showAlert("error", "", "No hay informacion sobre Buques", true);
            };
        </script>
    <?php else: ?>
    <div class="container">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <!-- <th>FOTO</th> -->
                            <th>RECALADAS</th>
                            <th>ATENCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buquesResponse->getBuques() as $buque): ?>
                            <tr>
                                <td><?= $buque->getId(); ?></td>
                                <td><?= $buque->getCodigo(); ?></td>
                                <td><?= $buque->getNombre(); ?></td>
                                <!-- <td>
                                    <?php if ($buque->getFoto()): ?>
                                        <img src="<?php echo $buque->getFoto(); ?>" alt="Foto del Buque" class="photo">
                                    <?php else: ?>
                                        No disponible
                                    <?php endif; ?>
                                </td> -->
                                <td>
                                    <a
                                        href="../Recaladas/index.php?action=listbybuque&buque=<?= $buque->getId() ?>"><?= $buque->getTotalRecaladas() ?></a>
                                </td>
                                <td><?= $buque->getTotalAtenciones() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

        function showAlert(icon, title, message, confirm = false) {
            let messageCreate = "Crear buque";
            let messageNo = "Cancelar";
            let messageOk = message;
            Swal.fire({
                icon: icon,
                title: title,
                text: message,
                showCancelButton: confirm,
                confirmButtonText: (!confirm) ? messageOk : messageCreate,
                cancelButtonText: messageNo,
            }).then((result) => {
                if (icon === "info") {
                    $('#molda-myModal').hide();
                }
                else
                    if (result.isConfirmed) {
                        $('#molda-myModal').hide();
                        if (confirm) {
                            window.location.href = '<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=create';
                        }
                    }
                    else {
                        $('#molda-myModal').hide();
                    }
            });
        }

    </script>
</body>

</html>

<?php
// SessionUtility::deleteItemInSession(ItemsInSessionEnum::LIST_BUQUES);
;
SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
SessionUtility::deleteItemInSession(ItemsInSessionEnum::INFO_MESSAGE);
?>
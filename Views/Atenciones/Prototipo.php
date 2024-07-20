<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones de la recalada</title>
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
    </style>
</head>

<body>
    <div class="header">
        Atenciones de la recalada Id: 1
    </div>
    <div class="icon-bar">
        <img src="https://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Home-icon.png" alt="Home">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-add-icon.png" alt="Add">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-search-icon.png" alt="Search">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-check-icon.png" alt="Check">
        <img src="https://icons.iconarchive.com/icons/icojam/blue-bits/48/document-delete-icon.png" alt="Delete">
    </div>
    <div class="sub-header">
        <span>Buque: Paradise</span>
        <span>Recalada ID: 1</span>
        <span>País: Colombia</span>
    </div>
    <div class="container">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Inicio</th>
                        <th>Cierre</th>
                        <th>Turnos</th>
                        <th>Turnos Creados</th>
                        <th>Turnos Disponibles</th>
                        <th>Supervisor</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
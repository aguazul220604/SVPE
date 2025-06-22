<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador de Proyectos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #fff;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        h2 {
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .nuevo-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 14px;
            border: 1px solid #000;
            border-radius: 6px;
            text-decoration: none;
            background-color: #fff;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }

        .buscar {
            margin-bottom: 20px;
        }

        .buscar input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            border-bottom: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .btn-editar,
        .btn-eliminar {
            padding: 6px 12px;
            border: 1px solid #555;
            border-radius: 6px;
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .btn-editar:hover {
            background-color: #eaeaea;
        }

        .btn-eliminar {
            border-color: #b20000;
            color: #b20000;
        }

        .btn-eliminar:hover {
            background-color: #fbeaea;
        }

        .no-result {
            text-align: center;
            color: #999;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Administrador de Proyectos</h2>
        <a href="/proyectos/create" class="nuevo-btn">＋ Nuevo proyecto</a>
    </div>

    <div class="buscar">
        <input type="text" name="buscar" placeholder="Buscar">
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de alta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Proyecto de ejemplo -->
            <tr>
                <td>Autonoguide</td>
                <td>11/06/2025 6:00 PM</td>
                <td>
                    <div class="acciones">
                        <button class="btn-editar">Editar</button>
                        <button class="btn-eliminar">Eliminar</button>
                    </div>
                </td>
            </tr>

            <!-- Sin resultados -->
            <!--
            <tr>
                <td colspan="3" class="no-result">No se encontraron proyectos.</td>
            </tr>
            -->
        </tbody>
    </table>
</div>

</body>
</html>

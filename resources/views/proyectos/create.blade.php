<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        h1 {
            text-align: right;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .section {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .grid-2, .grid-3 {
            display: grid;
            gap: 15px;
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        label {
            display: flex;
            flex-direction: column;
            font-weight: 500;
        }

        input, select, textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 5px;
            resize: vertical;
        }

        textarea {
            height: 80px;
        }
    </style>
</head>
<body>

<h1>Nuevo proyecto</h1>

<form>
    <div class="section">
        <div class="section-title">Proyecto</div>
        <div class="grid-2">
            <label>
                Usuario líder
                <select>
                    <option>Seleccione una opción</option>
                </select>
            </label>
            <label>
                Categoría
                <select>
                    <option>Seleccione una opción</option>
                </select>
            </label>
            <label>
                Estatus
                <select>
                    <option>Seleccione una opción</option>
                </select>
            </label>
            <label>
                Asesor
                <select>
                    <option>Seleccione una opción</option>
                </select>
            </label>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Descripción</div>
        <div class="grid-2">
            <label>
                Nombre
                <input type="text" placeholder="Nombre del proyecto">
            </label>
            <label>
                Propuesta
                <input type="text" placeholder="Propuesta">
            </label>
        </div>

        <div class="grid-3">
            <label>
                Introducción
                <textarea></textarea>
            </label>
            <label>
                Justificación
                <textarea></textarea>
            </label>
            <label>
                Descripción
                <textarea></textarea>
            </label>
            <label>
                Objetivos Generales
                <textarea></textarea>
            </label>
            <label>
                Objetivos Específicos
                <textarea></textarea>
            </label>
            <label>
                Estado del arte
                <textarea></textarea>
            </label>
        </div>
    </div>
</form>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .actions {
            margin-top: 20px;
            text-align: right;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>

<h1>Nuevo proyecto</h1>

<form method="POST" action="{{ route('proyectos.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="section">
        <div class="section-title">Información básica</div>
        <div class="grid-2">
            <label>
                Usuario líder
                <select name="IdUsuarioLider" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($lideres as $lider)
                        <option value="{{ $lider->IdUsuario }}">{{ $lider->Nombre }} ({{ $lider->Matricula }})</option>
                    @endforeach
                </select>
            </label>
            <label>
                Categoría
                <select name="IdCategoria" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->IdCategoria }}">{{ $categoria->Descripcion }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Estatus
                <select name="IdStatus" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($estatus as $status)
                        <option value="{{ $status->IdStatus }}">{{ $status->Descripcion }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Asesor
                <select name="IdAsesor">
                    <option value="">Seleccione una opción</option>
                    @foreach($asesores as $asesor)
                        <option value="{{ $asesor->IdUsuario }}">{{ $asesor->Nombre }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Documentación del proyecto</div>
        <div class="grid-2">
            <label>
                Nombre del proyecto
                <input type="text" name="Nombre" placeholder="Nombre del proyecto" required>
            </label>
            <label>
                Propuesta de valor
                <input type="text" name="PropValor" placeholder="Propuesta de valor" required>
            </label>
        </div>

        <div class="grid-3">
            <label>
                Introducción
                <textarea name="Introduccion"></textarea>
            </label>
            <label>
                Justificación
                <textarea name="Justificacion"></textarea>
            </label>
            <label>
                Descripción
                <textarea name="Descripcion"></textarea>
            </label>
            <label>
                Objetivos Generales
                <textarea name="ObjsGrals"></textarea>
            </label>
            <label>
                Objetivos Específicos
                <textarea name="ObjsEspec"></textarea>
            </label>
            <label>
                Estado del arte
                <textarea name="EdoArte"></textarea>
            </label>
        </div>
        
        <div style="margin-top: 20px;">
            <label>
                Documento PDF
                <input type="file" name="pdf" accept=".pdf" required>
                <small>Sube el documento completo del proyecto en formato PDF</small>
            </label>
        </div>
    </div>

    <div class="actions">
        <a href="{{ route('proyectos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
    </div>
</form>

</body>
</html>
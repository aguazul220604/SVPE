<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo proyecto</title>
    <style>body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    padding: 40px;
    color: #333;
}

h1 {
    text-align: right;
    margin-bottom: 40px;
    font-size: 24px;
    font-weight: bold;
}

form {
    max-width: 1000px;
    margin: auto;
}

.section {
    margin-bottom: 40px;
}

.section-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

label {
    display: flex;
    flex-direction: column;
    font-weight: 500;
    font-size: 14px;
}

input[type="text"],
select,
textarea {
    margin-top: 8px;
    padding: 10px;
    border: 1px solid #999;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
}

textarea {
    resize: vertical;
    min-height: 80px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #1d1d1f;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #333;
}
</style>
</head>
<body>

<h1>Nuevo proyecto</h1>

<form method="POST" action="{{ route('proyectos.store') }}">
    @csrf
    <div class="section">
        <div class="section-title">Proyecto</div>
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
        <div class="section-title">Descripción</div>
        <div class="grid-2">
            <label>
                Nombre
                <input type="text" name="Nombre" placeholder="Nombre del proyecto" required>
            </label>
            <label>
                Propuesta
                <input type="text" name="PropValor" placeholder="Propuesta" required>
            </label>
        </div>

        <div class="grid-3">
            <label>
                Introducción
                <textarea name="Introduccion" required></textarea>
            </label>
            <label>
                Justificación
                <textarea name="Justificacion" required></textarea>
            </label>
            <label>
                Descripción
                <textarea name="Descripcion" required></textarea>
            </label>
            <label>
                Objetivos Generales
                <textarea name="ObjsGrals" required></textarea>
            </label>
            <label>
                Objetivos Específicos
                <textarea name="ObjsEspec" required></textarea>
            </label>
            <label>
                Estado del arte
                <textarea name="EdoArte" required></textarea>
            </label>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Guardar Proyecto
            </button>
        </div>
    </div>
</form>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resumen del Proyecto</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        h1 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 5px; }
        h2 { color: #2980b9; margin-top: 20px; }
        .section { margin-bottom: 15px; }
        .info-label { font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { width: 150px; }
        .footer { margin-top: 50px; font-size: 0.8em; text-align: center; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Resumen del Proyecto</h1>
        <p>Incubadora de Empresas - UPT</p>
    </div>

    <div class="section">
        <h2>Información específica</h2>
        <p><span class="info-label">Nombre:</span> {{ $proyecto->descripcion->Nombre }}</p>
        <p><span class="info-label">Líder:</span> {{ $proyecto->lider->Nombre }} ({{ $proyecto->lider->Matricula }})</p>
        <p><span class="info-label">Categoría:</span> {{ $proyecto->categoria->Descripcion }}</p>
        <p><span class="info-label">Estatus:</span> {{ $proyecto->descripcion->estatus->Descripcion }}</p>
        <p><span class="info-label">Propuesta de valor:</span> {{ $proyecto->descripcion->PropValor }}</p>
    </div>

    <div class="section">
        <h2>Descripción del Proyecto</h2>
        <p>{{ $proyecto->descripcion->Descripcion }}</p>
    </div>

    <div class="section">
        <h2>Objetivos</h2>
        <p><span class="info-label">Generales:</span></p>
        <p>{{ $proyecto->descripcion->ObjsGrals }}</p>
        
        <p><span class="info-label">Específicos:</span></p>
        <p>{{ $proyecto->descripcion->ObjsEspec }}</p>
    </div>

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i') }} por el sistema de incubación de la UPT</p>
    </div>
</body>
</html>
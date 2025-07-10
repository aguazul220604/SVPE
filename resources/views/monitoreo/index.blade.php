<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
   
    <style>
        
    .btn-status {
        background-color: #dc3545; 
        border: 1px solid #dc3545;
    }

    .btn-status.active,
    .btn-status:hover {
        background-color: #a71d2a;
        border-color: #a71d2a;
    }
    .cat {
        text-decoration: none !important;
    }

    /* Mejora la separación de fechas */
    .convocatoria-header {
    background-color: #007bff;
    color: white;
    border-radius: 4px;
    font-weight: 500;
}

.info-fechas .fecha {
    margin-right: 20px;
    font-size: 14px;
    margin-right: 7rem;
}

.categoria {
    font-size: 14px;
    margin-right: 15px;
    text-decoration: none; /* elimina subrayado */
}
.badge-estatus {
    padding: 5px 10px;
    font-size: 12px;
    margin-left: 250px;
}

.badge {
    padding: 5px 10px;
    font-size: 12px;
    margin-left: auto;
}

.btn-toggle {
    background: transparent;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
}


    .info-etiquetas .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
    }
</style>


</head>
<body>
  
@extends('layouts.app')

@section('title', 'Monitoreo de Convocatorias')
@section('content')
<div class="container">
    <h1>Monitoreo de Convocatorias</h1>
    
    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('monitoreo.index', ['estatus' => 'VIGENTE']) }}" 
           class="btn {{ request('estatus') == 'VIGENTE' ? 'btn-primary' : 'btn-outline-primary' }}">VIGENTE</a>
        <a href="{{ route('monitoreo.index', ['estatus' => 'PROXIMAMENTE']) }}" 
           class="btn {{ request('estatus') == 'PROXIMAMENTE' ? 'btn-primary' : 'btn-outline-primary' }}">PROXIMAMENTE</a>
        <a href="{{ route('monitoreo.index', ['estatus' => 'CADUCADA']) }}" 
           class="btn {{ request('estatus') == 'CADUCADA' ? 'btn-primary' : 'btn-outline-primary' }}">CADUCADA</a>
        <a href="{{ route('monitoreo.index', ['estatus' => 'TODAS']) }}" 
           class="btn {{ request('estatus') == 'TODAS' ? 'btn-primary' : 'btn-outline-primary' }}">TODAS</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @foreach($convocatorias as $convocatoria)
                @php
                    $today = now();
                    if($today->between($convocatoria->FechaInicio, $convocatoria->FechaFin)) {
                        $estatus = 'VIGENTE';
                        $badgeClass = 'bg-success';
                    } elseif($today->lt($convocatoria->FechaInicio)) {
                        $estatus = 'PROXIMAMENTE';
                        $badgeClass = 'bg-warning text-dark';
                    } else {
                        $estatus = 'CADUCADA';
                        $badgeClass = 'bg-danger';
                    }
                @endphp
                
                <div class="mb-4 p-3 border-bottom">
                    <div class="convocatoria-header d-flex justify-content-between align-items-center mb-2 p-2 px-3">
                            <div class="info-fechas d-flex flex-wrap align-items-center gap-3">
                            <span class="fecha"><strong>FECHA INICIO:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaInicio)) }}</span>
                            <span class="fecha"><strong>FECHA FIN:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaFin)) }}</span>
                            <span class="cat">{{ $convocatoria->categoria->Descripcion ?? 'Sin categoría' }}</span>

                            <span class="badge-estatus {{ $badgeClass }}">{{ $estatus }}</span>
                        </div>
                    </div>
                    
                    @if($convocatoria->proyectosConvocatoria->isNotEmpty())
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>PROYECTO</th>
                                        <th>ASESOR</th>
                                        <th>LÍDER</th>
                                        <th>CARRERA</th>
                                        <th>ESTATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($convocatoria->proyectosConvocatoria as $index => $proyecto)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $proyecto->proyecto->descripcion->Nombre ?? 'Sin nombre' }}</td>
                                            <td>{{ optional($proyecto->usuarioPostula)->Nombre ?? 'Sin asesor' }}</td>
                                            <td>{{ optional($proyecto->proyecto->lider)->Nombre ?? 'Sin líder' }}</td>
                                            <td>{{ optional(optional($proyecto->proyecto->lider)->carrera)->Descripcion ?? 'Sin carrera' }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = [
                                                        'Aprobado' => 'bg-success',
                                                        'Rechazado' => 'bg-danger',
                                                        'En revisión' => 'bg-warning text-dark',
                                                        'Pendiente' => 'bg-secondary'
                                                    ][$proyecto->EstatusConvocatoria] ?? 'bg-info';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $proyecto->EstatusConvocatoria }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">No hay proyectos vinculados a esta convocatoria</div>
                    @endif
                </div>
            @endforeach
            
            @if($convocatorias->isEmpty())
                <div class="alert alert-info">No hay convocatorias con el filtro seleccionado</div>
            @endif
        </div>
    </div>
</div>
@endsection
</body>
<script>
function toggleProyectos(index) {
    const container = document.getElementById(`proyectos-${index}`);
    container.classList.toggle('d-none');
}
</script>
</html>
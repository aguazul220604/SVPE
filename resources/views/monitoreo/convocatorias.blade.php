<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo de Convocatorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/monitoreo/convocatorias.css') }}">

    <style>
      
    </style>
</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h2 >
           Convocatorias
        </h2>
        <a href="{{ route('monitoreo.index') }}" class="nuevo-proyecto">
           Volver a Proyectos
        </a>
    </div>

    <!-- Filtros con colores específicos -->
    <div class="filter-container">
        <a href="{{ route('monitoreo.convocatorias', ['estatus' => 'TODAS']) }}" 
           class="filter-btn filter-btn-todas {{ request('estatus') == 'TODAS' || !request('estatus') ? 'active' : '' }}">
           <i class="fas fa-layer-group"></i> TODAS
        </a>
        <a href="{{ route('monitoreo.convocatorias', ['estatus' => 'Vigente']) }}" 
           class="filter-btn filter-btn-vigente {{ request('estatus') == 'Vigente' ? 'active' : '' }}">
           <i class="fas fa-check-circle"></i> VIGENTE
        </a>
        <a href="{{ route('monitoreo.convocatorias', ['estatus' => 'Próximamente']) }}" 
           class="filter-btn filter-btn-proximamente {{ request('estatus') == 'Próximamente' ? 'active' : '' }}">
           <i class="fas fa-clock"></i> PROXIMAMENTE
        </a>
        <a href="{{ route('monitoreo.convocatorias', ['estatus' => 'Caducada']) }}" 
           class="filter-btn filter-btn-caducada {{ request('estatus') == 'Caducada' ? 'active' : '' }}">
           <i class="fas fa-times-circle"></i> CADUCADA
        </a>
    </div>

    <!-- Lista de Convocatorias -->
    <div class="card-contenedor">
        <div class="card-body">
            @if($convocatorias->isEmpty())
                <div class="alert-vacia">
                    <i class="fas fa-folder-open"></i>
                    <h4>No hay convocatorias con el filtro seleccionado</h4>
                    <p class="mb-0">Intenta con otro filtro o verifica la información</p>
                </div>
            @else
                <div class="convocatoria-container">
                    @foreach($convocatorias as $convocatoria)
                        @php
                            $estatus = $convocatoria->estado->descripcion ?? 'DESCONOCIDO';
                            $badgeClass = 'bg-secondary';
                            if ($estatus == 'Vigente') {
                                $badgeClass = 'bg-vigente';
                            } elseif ($estatus == 'Próximamente') {
                                $badgeClass = 'bg-proximamente';
                            } elseif ($estatus == 'Caducada') {
                                $badgeClass = 'bg-caducada';
                            }
                        @endphp

                        <div class="proyecto-card">
                            <!-- Encabezado con nombre, estado y fechas -->
                            <div class="convocatoria-header">
                                <a href="{{ route('monitoreo.convocatoria.proyectos', $convocatoria->idConvocatoria) }}" style="text-decoration: none;">
                                    <h3 class="convocatoria-title">
                                        {{ $convocatoria->nombre ?: 'Sin nombre' }}
                                        <span class="status-badge {{ $badgeClass }}">
                                            {{ $estatus }}
                                        </span>
                                    </h3>
                                </a>
                                <div class="fechas-convocatoria">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($convocatoria->fecha_inicio)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($convocatoria->fecha_fin)->format('d/m/Y') }}
                                </div>
                            </div>
                            
                            <!-- Tabla de proyectos -->
                            @if($convocatoria->proyectos->isNotEmpty())
                                <div class="projects-table-container">
                                    <table class="table-proyectos">
                                        <thead>
                                            <tr>
                                                <th>Proyecto</th>
                                                <th style="text-align: right;">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($convocatoria->proyectos as $proyecto)
                                                @php
                                                    $estadoProyecto = $proyecto->descripcion->estado->nombre ?? 'Desconocido';
                                                    $badgeClass = 'bg-secondary';
                                                    if ($estadoProyecto == 'Aprobado') {
                                                        $badgeClass = 'bg-aprobado';
                                                    } elseif ($estadoProyecto == 'Rechazado') {
                                                        $badgeClass = 'bg-rechazado';
                                                    } elseif ($estadoProyecto == 'Inicio') {
                                                        $badgeClass = 'bg-inicio';
                                                    } elseif ($estadoProyecto == 'Desarrollo') {
                                                        $badgeClass = 'bg-desarrollo';
                                                    } elseif ($estadoProyecto == 'Concluido') {
                                                        $badgeClass = 'bg-concluido';
                                                    }
                                                @endphp
                                                
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('monitoreo.show2', $proyecto->idProyecto) }}" class="project-name">
                                                            {{ $proyecto->descripcion->nombre ?? 'N/A' }}
                                                        </a>
                                                        <div class="project-leader">
                                                            Líder: {{ $proyecto->lider->nombres ?? 'No asignado' }}
                                                        </div>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <span class="badge-estado {{ $badgeClass }}">
                                                            {{ $estadoProyecto }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="no-projects-alert">
                                    <i class="fas fa-info-circle"></i>
                                    No hay proyectos en esta convocatoria
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="paginacion-personalizada">
                    {{ $convocatorias->links('vendor.pagination.circular') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
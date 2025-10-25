<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo de Proyectos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('css/monitoreo/indexM.css') }}">
    <style>
        
    </style>
</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="section-card">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="page-header">
            <h1 >
               Monitoreo de Proyectos
            </h1>
            <a href="{{ route('monitoreo.convocatorias') }}" class="nuevo-proyecto">
              Ver Convocatorias
            </a>
        </div>

        <!-- Filtros -->
        <div class="filter-container">
            <a href="{{ route('monitoreo.index', ['estatus' => 'TODOS']) }}" 
               class="filter-btn filter-btn-TODOS {{ request('estatus') == 'TODOS' ? 'active' : '' }}">
               <i class="fas fa-layer-group"></i> TODOS
            </a>
            @foreach($estatusDisponibles as $estatus)
                <a href="{{ route('monitoreo.index', ['estatus' => $estatus->idEstado]) }}" 
                   class="filter-btn filter-btn-{{ $estatus->idEstado }} {{ request('estatus') == $estatus->idEstado ? 'active' : '' }}"
                   title="{{ $estatus->descripcion ?? '' }}">
                   <i class="{{ $estatus->icono ?? 'fas fa-circle' }}"></i> {{ $estatus->nombre }}
                </a>
            @endforeach
        </div>

        <!-- Lista de Proyectos -->
        @if($proyectos->isEmpty())
            <div class="alert alert-info text-center py-4">
                <i class="fas fa-folder-open fa-3x mb-3" style="color: var(--secondary-color);"></i>
                <h4>No hay proyectos con el filtro seleccionado</h4>
                <p class="mb-0">Intenta con otro filtro o verifica la información</p>
            </div>
        @else
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre del Proyecto</th>
                            <th>Líder</th>
                            <th>Carrera</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyectos as $proyecto)
                        <tr>
                            <td>
                                <a href="{{ route('monitoreo.show2', $proyecto->idProyecto) }}" class="project-link">
                                    <div class="project-name">{{ $proyecto->descripcion->nombre ?? 'Sin nombre' }}</div>
                                    <div class="project-id">ID: {{ $proyecto->idProyecto }}</div>
                                </a>
                            </td>
                            <td>
                                <div class="leader-name">{{ $proyecto->lider->nombres ?? 'Sin líder' }}</div>
                                <div class="leader-email">{{ $proyecto->lider->email ?? '' }}</div>
                            </td>
                            <td class="career-name">{{ $proyecto->lider->carrera->descripcion ?? 'Sin carrera' }}</td>
                            <td>
                                <form method="POST" action="{{ route('monitoreo.updateStatus', $proyecto->idProyecto) }}" class="change-status-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="status-container">
                                        @foreach($estatusDisponibles as $estatus)
                                            <button type="submit" name="estatus" value="{{ $estatus->idEstado }}" 
                                                    class="status-btn status-btn-{{ $estatus->idEstado }} {{ $proyecto->descripcion->idEstado == $estatus->idEstado ? 'active pulse-animation' : '' }}"
                                                    title="{{ $estatus->descripcion ?? '' }}">
                                                <i class="{{ $estatus->icono ?? 'fas fa-circle' }}"></i>
                                                {{ $estatus->nombre }}
                                            </button>
                                        @endforeach
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="paginacion-personalizada">
                            {{ $proyectos->links('vendor.pagination.circular') }}
                        </div>
        @endif
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.change-status-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const statusButton = document.activeElement;
            const statusValue = statusButton.value;
            const statusText = statusButton.textContent.trim();
            const statusColor = window.getComputedStyle(statusButton).backgroundColor;
            
            Swal.fire({
                title: '¿Confirmar cambio de estado?',
                html: `¿Estás seguro que deseas cambiar el estado del proyecto a <span style="color: ${statusColor}; font-weight: bold">${statusText}</span>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f73878',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'shadow-none',
                    cancelButton: 'shadow-none'
                },
                background: '#ffffff',
                backdrop: `
                    rgba(247, 56, 120, 0.1)
                    left top
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'estatus';
                    hiddenInput.value = statusValue;
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    });
});
</script>
</body>
</html>
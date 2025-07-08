@extends('layouts.app')

@section('title', 'Monitoreo de Convocatorias')
@section('content')
<div class="container">
    <h1>Monitoreo de Convocatorias</h1>
    
    <div class="mb-4">
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">
                            <strong>FECHA INICIO:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaInicio)) }}
                            <strong>FECHA FIN:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaFin)) }}
                            <span class="badge bg-secondary">{{ $convocatoria->categoria->Descripcion ?? 'Sin categoría' }}</span>
                            <span class="badge {{ $badgeClass }}">{{ $estatus }}</span>
                        </h5>
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
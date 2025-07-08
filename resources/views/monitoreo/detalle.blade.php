@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de Convocatoria</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h4>
                <strong>FECHA INICIO:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaInicio)) }}
                <strong>FECHA FIN:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaFin)) }}
                <span class="badge bg-secondary">{{ $convocatoria->categoria->Descripcion }}</span>
                <span class="badge bg-success">{{ $convocatoria->estatus->Descripcion }}</span>
            </h4>
        </div>
    </div>
    
    <h3>Proyectos vinculados</h3>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>PROYECTO</th>
                        <th>ASESOR</th>
                        <th>LÍDER</th>
                        <th>CARRERA</th>
                        <th>ESTATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proyectos as $index => $proyecto)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $proyecto->proyecto->descripcion->Nombre ?? 'Sin nombre' }}</td>
                            <td>HUGO ANGELES GONZALEZ</td>
                            <td>{{ $proyecto->proyecto->lider->Nombre ?? 'Sin líder' }}</td>
                            <td>{{ $proyecto->proyecto->lider->carrera->Descripcion ?? 'Sin carrera' }}</td>
                            <td>
                                <span class="badge bg-{{ $proyecto->EstatusConvocatoria == 'Aprobado' ? 'success' : 'warning' }}">
                                    {{ $proyecto->EstatusConvocatoria }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    
                    @if($proyectos->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No hay proyectos vinculados a esta convocatoria</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('monitoreo.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
</div>
@endsection
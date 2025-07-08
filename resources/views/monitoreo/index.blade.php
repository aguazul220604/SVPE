@extends('layouts.app')

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
                <div class="mb-4 p-3 border-bottom">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>
                                <strong>FECHA INICIO:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaInicio)) }}
                                <strong>FECHA FIN:</strong> {{ date('d/m/Y', strtotime($convocatoria->FechaFin)) }}
                                <span class="badge bg-secondary">{{ $convocatoria->categoria->Descripcion }}</span>
                                <span class="badge bg-success">{{ $convocatoria->estatus->Descripcion }}</span>
                            </h5>
                        </div>
                        <div>
                            <a href="{{ route('monitoreo.detalle', $convocatoria->IdConvocatoria) }}" 
                               class="btn btn-sm btn-info">Ver detalle</a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($convocatorias->isEmpty())
                <div class="alert alert-info">No hay convocatorias con el filtro seleccionado</div>
            @endif
        </div>
    </div>
</div>
@endsection
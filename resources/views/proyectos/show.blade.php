@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Proyecto</h1>
    
    <div class="card">
        <div class="card-header">
            <h2>{{ $proyecto->descripcion->Nombre }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Información Básica</h4>
                    <p><strong>Líder:</strong> {{ $proyecto->lider->Nombre }}</p>
                    <p><strong>Categoría:</strong> {{ $proyecto->categoria->Descripcion }}</p>
                    <p><strong>Estatus:</strong> {{ $proyecto->descripcion->estatus->Descripcion }}</p>
                    <p><strong>Fecha de creación:</strong> {{ $proyecto->FechaAlta }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Propuesta de Valor</h4>
                    <p>{{ $proyecto->descripcion->PropValor }}</p>
                </div>
            </div>
            
            <div class="mt-4">
                <h4>Descripción Detallada</h4>
                <div class="mb-3">
                    <h5>Introducción</h5>
                    <p>{{ $proyecto->descripcion->Introduccion }}</p>
                </div>
                <div class="mb-3">
                    <h5>Justificación</h5>
                    <p>{{ $proyecto->descripcion->Justificacion }}</p>
                </div>
                <div class="mb-3">
                    <h5>Objetivos Generales</h5>
                    <p>{{ $proyecto->descripcion->ObjsGrals }}</p>
                </div>
                <div class="mb-3">
                    <h5>Objetivos Específicos</h5>
                    <p>{{ $proyecto->descripcion->ObjsEspec }}</p>
                </div>
            </div>
            
            @if($proyecto->integrantes->count() > 0)
            <div class="mt-4">
                <h4>Integrantes</h4>
                <ul>
                    @foreach($proyecto->integrantes as $integrante)
                        <li>{{ $integrante->Nombre }} ({{ $integrante->Matricula }})</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('proyectos.edit', $proyecto->IdProyecto) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('proyectos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
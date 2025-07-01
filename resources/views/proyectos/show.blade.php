@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 border-bottom pb-2">Detalles del Proyecto</h1>
    
    <div class="bg-light p-4 rounded shadow-sm">
        <h2 class="h4 mb-3 text-primary">{{ $proyecto->descripcion->Nombre }}</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="mb-3 text-muted">Información Básica</h5>
                <p><strong>Líder:</strong> {{ $proyecto->lider->Nombre }}</p>
                <p><strong>Categoría:</strong> {{ $proyecto->categoria->Descripcion }}</p>
                <p><strong>Estatus:</strong> {{ $proyecto->descripcion->estatus->Descripcion }}</p>
                <p><strong>Fecha de creación:</strong> {{ $proyecto->FechaAlta }}</p>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3 text-muted">Propuesta de Valor</h5>
                <p>{{ $proyecto->descripcion->PropValor }}</p>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="text-muted">Descripción Detallada</h5>
            <div class="mb-3">
                <strong>Introducción:</strong>
                <p>{{ $proyecto->descripcion->Introduccion }}</p>
            </div>
            <div class="mb-3">
                <strong>Justificación:</strong>
                <p>{{ $proyecto->descripcion->Justificacion }}</p>
            </div>
            <div class="mb-3">
                <strong>Objetivos Generales:</strong>
                <p>{{ $proyecto->descripcion->ObjsGrals }}</p>
            </div>
            <div class="mb-3">
                <strong>Objetivos Específicos:</strong>
                <p>{{ $proyecto->descripcion->ObjsEspec }}</p>
            </div>
        </div>

        @if($proyecto->integrantes->count() > 0)
        <div class="mb-4">
            <h5 class="text-muted">Integrantes</h5>
            <ul class="list-unstyled ps-3">
                @foreach($proyecto->integrantes as $integrante)
                    <li>- {{ $integrante->Nombre }} ({{ $integrante->Matricula }})</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('proyectos.edit', $proyecto->IdProyecto) }}" class="btn btn-outline-primary">Editar</a>
            <a href="{{ route('proyectos.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection

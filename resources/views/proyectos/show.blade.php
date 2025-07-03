@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .section-card {
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-left: 5px solid #0d6efd;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .section-title {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
        color: #0d6efd;
    }

    .btn-custom-primary {
        background-color: #0d6efd;
        color: white;
        border: none;
    }

    .btn-custom-primary:hover {
        background-color: #0b5ed7;
    }

    .btn-custom-secondary {
        border: 1px solid #6c757d;
        color: #6c757d;
    }

    .btn-custom-secondary:hover {
        background-color: #f8f9fa;
    }

    .list-unstyled li::before {
        content: '•';
        color: #0d6efd;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
</style>

<div class="container py-4">
    <h1 class="mb-4 section-title">Detalles del Proyecto</h1>

    <div class="section-card">
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
    </div>

    <div class="section-card">
        <h5 class="section-title">Descripción Detallada</h5>
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
        <div class="mb-3">
            <strong>Estado del arte:</strong>
            <p>{{ $proyecto->descripcion->EdoArte }}</p>
        </div>
        <div class="mb-3">
            <strong>Fortalezas:</strong>
            <p>{{ $proyecto->descripcion->Fortalezas }}</p>
        </div>
        <div class="mb-3">
            <strong>Oportunidades:</strong>
            <p>{{ $proyecto->descripcion->Oportunidades }}</p>
        </div>
        <div class="mb-3">
            <strong>Debilidades:</strong>
            <p>{{ $proyecto->descripcion->Debilidades }}</p>
        </div>
        <div class="mb-3">
            <strong>Amenazas:</strong>
            <p>{{ $proyecto->descripcion->Amenazas }}</p>
        </div>
        <div class="mb-3">
            <strong>Metodologías:</strong>
            <p>{{ $proyecto->descripcion->Metodologias }}</p>
        </div>
        <div class="mb-3">
            <strong>Costos:</strong>
            <p>{{ $proyecto->descripcion->Costos }}</p>
        </div>
        <div class="mb-3">
            <strong>Resultados:</strong>
            <p>{{ $proyecto->descripcion->Resultados }}</p>
        </div>
        <div class="mb-3">
            <strong> Referencias:</strong>
            <p>{{ $proyecto->descripcion->Referencias }}</p>
        </div>
    </div>

    @if($proyecto->integrantes->count() > 0)
    <div class="section-card">
        <h5 class="section-title">Integrantes</h5>
        <ul class="list-unstyled ps-3">
            @foreach($proyecto->integrantes as $integrante)
                <li>{{ $integrante->Nombre }} ({{ $integrante->Matricula }})</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('proyectos.edit', $proyecto->IdProyecto) }}" class="btn btn-custom-primary">Editar</a>
        <a href="{{ route('proyectos.index') }}" class="btn btn-custom-secondary">Volver</a>
    </div>
</div>
@endsection

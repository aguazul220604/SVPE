<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver-proyecto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
    }
      .boton-proyecto{
    border: 1px solid #f73878;
    color: #f73878;
    background-color: transparent;
    border-radius: 8px;
    padding: 10px 21px;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
    text-decoration: none;
    margin-right: 20px;

    }

  .boton-proyecto:hover {
        background-color: #f73878;
        color: white;
        text-decoration: none;
    }
    .section {
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .section-card {
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-left: 5px solid #f73878;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .section-title {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
        color: #f73878;
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
     .btn-regresar{
        color: #ffffff;
        background-color: #6C757D;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-right: 20px;
        }
         .btn-regresar:hover {
        background-color: #5f6365;
        color: white;
        text-decoration: none;
        }
</style>
</head>
<body>
   @extends('layouts.app')

@section('content')

<div class="section">
    <h2 class="mb-4 ">Detalles del Proyecto</h2>

    <div class="section-card">
        <h2 class="h4 mb-3 ">{{ $proyecto->descripcion->nombre }}</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="mb-3 text-muted">Información específica</h5>
                <p><strong>Líder:</strong> 
              @if($lideres)
                    {{ $lideres->usuario->nombres }} {{ $lideres->usuario->apellido_paterno }}
                @else
                    <em>No asignado</em>
                @endif</p>
                <p><strong>Asesor:</strong>
               @if($asesores)
                    {{ $asesores->usuario->nombres }} {{ $asesores->usuario->apellido_paterno }}
                @else
                    <em>No asignado</em>
                @endif</p>

                <p><strong>Categoría:</strong>{{ $proyecto->convocatoria->pertenencia->categoria->descripcion ?? 'No asignado' }}</p>
                <p><strong>Convocatoria:</strong> {{$proyecto->convocatoria->nombre??'No asignada' }}</p>
                <p><strong>Estatus:</strong>{{ $proyecto->descripcion->estado->nombre ?? 'Sin estatus' }}</p>
                <p><strong>Fecha de creación:</strong> {{ $proyecto->fecha_registro ?? 'No asignado' }}</p>
                <label>
               <label>
                <strong>Participantes seleccionados:</strong>
                <div id="previewParticipantes">
                    <ul class="listado" id="listaParticipantes">
                       @foreach($participantes as $p)
                            @if($p->usuario)
                                <li>{{ $p->usuario->nombres }} {{ $p->usuario->apellido_paterno }} - {{ $p->usuario->matricula }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <strong>Colaboradores:</strong>
                @foreach ($colaboradores as $colaborador)
                    <li>{{ $colaborador->nombres }} {{ $colaborador->apellido_paterno }}</li>
                @endforeach
            </label>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3 text-muted">Propuesta de Valor</h5>
                <p>{{ $proyecto->descripcion->propuesta_valor ?? 'No asignado'}}</p>
            </div>
        </div>
    </div>

   <div class="section-card">
        <h5 class="section-title">Descripción Detallada</h5>

        @if(!empty($proyecto->descripcion->introduccion))
        <div class="mb-3">
            <strong>Introducción:</strong>
            <p>{{ $proyecto->descripcion->introduccion?? 'No asignado' }}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->justificacion))
        <div class="mb-3">
            <strong>Justificación:</strong>
            <p>{{ $proyecto->descripcion->justificacion ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->objetivos_generales))
        <div class="mb-3">
            <strong>Objetivos Generales:</strong>
            <p>{{ $proyecto->descripcion->objetivos_generales ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->objetivos_especificos))
        <div class="mb-3">
            <strong>Objetivos Específicos:</strong>
            <p>{{ $proyecto->descripcion->objetivos_especificos ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->estado_arte))
        <div class="mb-3">
            <strong>Estado del arte:</strong>
            <p>{{ $proyecto->descripcion->estado_arte ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->fortalezas))
        <div class="mb-3">
            <strong>Fortalezas:</strong>
            <p>{{ $proyecto->descripcion->fortalezas ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->oportunidades))
        <div class="mb-3">
            <strong>Oportunidades:</strong>
            <p>{{ $proyecto->descripcion->oportunidades ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->debilidades))
        <div class="mb-3">
            <strong>Debilidades:</strong>
            <p>{{ $proyecto->descripcion->debilidades ?? 'No asignado' }}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->amenazas))
        <div class="mb-3">
            <strong>Amenazas:</strong>
            <p>{{ $proyecto->descripcion->amenazas ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->metodologias))
        <div class="mb-3">
            <strong>Metodologías:</strong>
            <p>{{ $proyecto->descripcion->metodologias ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->costos))
        <div class="mb-3">
            <strong>Monto:</strong>
            <p>{{ $proyecto->descripcion->costos ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->resultados))
        <div class="mb-3">
            <strong>Resultados:</strong>
            <p>{{ $proyecto->descripcion->resultados ?? 'No asignado'}}</p>
        </div>
        @endif

        @if(!empty($proyecto->descripcion->referencias))
        <div class="mb-3">
            <strong>Referencias:</strong>
            <p>{{ $proyecto->descripcion->referencias ?? 'No asignado'}}</p>
        </div>
        @endif
    </div>
    <div class="d-flex justify-content-end gap-2">
    <a href="{{ session('previous_url') ?? route('monitoreo.index') }}" class="btn-regresar">
        Regresar
    </a>
</div
</div>
@endsection

</body>
</html>
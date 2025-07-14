<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .boton-proyecto{
    border: 1px solid #f73878;
    color: #f73878;
    background-color: transparent;
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 12px;
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
     .nuevo-proyecto{
    border: 1px solid #f73878;
    color: #f73878;
    background-color: transparent;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
    text-decoration: none;
    position:between;
    }

    .nuevo-proyecto:hover {
        background-color: #f73878;
        color: white;
        text-decoration: none;
    }
    .section-card {
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
        .boton-eliminar{
    border: 1px solid #6C757D;
    color: #6C757D;
    background-color: transparent;
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
    text-decoration: none;
    margin-right: 20px;

    }

    .boton-eliminar:hover {
        background-color: #5f6365;
        color: white;
        text-decoration: none;
    }
     .nuevo{
        color: #ffffff;
        background-color: #f73878;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-right: 20px;
        border: none;

        }
         .nuevo:hover {
        background-color: #db386e;
        color: white;
        text-decoration: none;
        }
    </style>
</head>
<body>
@extends('layouts.app')

@section('content')

<div class="section-card">
 <h1>Administrador de Proyectos</h1>
    <div class="d-flex justify-content-end flex-wrap gap-2">
        <a href="{{ route('proyectos.create') }}" class="nuevo"> Nuevo proyecto</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form class="mb-3" method="GET" action="{{ route('proyectos.index') }}">
        <input type="text" name="buscar" class="form-control w-auto d-inline-block" placeholder="Buscar" value="{{ request('buscar') }}">
        <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
    </form>

    <table class="table table-striped ">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyectos as $proyecto)
            <tr>
                <td>{{ $proyecto->descripcion->Nombre ?? 'Sin nombre' }}</td>
                <td>{{ $proyecto->categoria->Descripcion ?? 'Sin categoría' }}</td>
                <td>{{ $proyecto->descripcion->estatus->Descripcion ?? 'Sin estatus' }}</td>
                <td class="d-flex flex-wrap gap-2">
                    <a href="{{ route('proyectos.show', $proyecto->IdProyecto) }}" class="boton-proyecto">Ver</a>
                    <a href="{{ route('proyectos.edit', $proyecto->IdProyecto) }}" class="boton-proyecto">Editar</a>
                  <form action="{{ route('proyectos.destroy', $proyecto->IdProyecto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="boton-eliminar">Eliminar</button>
                  </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">No se encontraron proyectos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>

</div>

@endsection

</body>
</html>
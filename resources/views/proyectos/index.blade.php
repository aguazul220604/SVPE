@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header d-flex justify-content-between align-items-center mb-4">
        <h2>Administrador de Proyectos</h2>
        <a href="{{ route('proyectos.create') }}" class="btn btn-primary">＋ Nuevo proyecto</a>
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

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Líder</th>
                <th>Categoría</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyectos as $proyecto)
            <tr>
                <td>{{ $proyecto->IdProyecto }}</td>
                <td>{{ $proyecto->descripcion->Nombre ?? 'Sin nombre' }}</td>
                <td>{{ $proyecto->lider->Nombre ?? 'Sin líder' }}</td>
                <td>{{ $proyecto->categoria->Descripcion ?? 'Sin categoría' }}</td>
                <td>{{ $proyecto->descripcion->estatus->Descripcion ?? 'Sin estatus' }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('proyectos.show', $proyecto->IdProyecto) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('proyectos.edit', $proyecto->IdProyecto) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('proyectos.destroy', $proyecto->IdProyecto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
@endsection

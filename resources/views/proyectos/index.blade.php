<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/proyectos/index.css') }}">
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="section-card">
            <h1>Administrador de Proyectos</h1>
            <div class="d-flex justify-content-end flex-wrap gap-2">
                <a href="{{ route('proyectos.create') }}" class="nuevo"> Nuevo proyecto</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form class="mb-3" method="GET" action="{{ route('proyectos.index') }}">
                <input type="text" name="buscar" class="form-control w-auto d-inline-block" placeholder="Buscar"
                    value="{{ request('buscar') }}">
                <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
            </form>

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Convocatoria</th>
                        <th>Estatus</th>
                        <th>Fecha alta</th>
                        <th class="text-center"></th> <!-- NUEVO -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyectos as $proyecto)
                        <tr>
                            <td>{{ $proyecto->descripcion->nombre ?? 'Sin nombre' }}</td>
                            <td>
                                {{ $proyecto->convocatoria->nombre ?? 'Sin convocatoria' }}

                            </td>

                            <td>
                                @php
                                    $estadoProyecto = $proyecto->descripcion->estado->nombre ?? 'Sin estatus';
                                    $badgeClass = 'bg-secondary';
                                    if ($estadoProyecto == 'Aprobado') {
                                        $badgeClass = 'bg-aprobado';
                                    } elseif ($estadoProyecto == 'Rechazado') {
                                        $badgeClass = 'bg-rechazado';
                                    } elseif ($estadoProyecto == 'Inicio') {
                                        $badgeClass = 'bg-inicio';
                                    } elseif ($estadoProyecto == 'Desarrollo') {
                                        $badgeClass = 'bg-desarrollo';
                                    } elseif ($estadoProyecto == 'Concluido') {
                                        $badgeClass = 'bg-concluido';
                                    }
                                @endphp

                                <span class="badge-estado {{ $badgeClass }}">
                                    {{ $estadoProyecto }}
                                </span>
                            </td>
                            <td>{{ $proyecto->fecha_registro }}</td>
                            <!-- <td class="d-flex flex-wrap justify-content-center gap-2 w-100"> -->
                            <td class="d-flex flex-wrap justify-content-between gap-2 w-100">
                                <a href="{{ route('proyectos.show', $proyecto->idProyecto) }}"
                                    class="boton-proyecto">Ver</a>
                                <a href="{{ route('proyectos.edit', $proyecto->idProyecto) }}"
                                    class="boton-proyecto">Editar</a>
                                <form action="{{ route('proyectos.destroy', $proyecto->idProyecto) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')"
                                    style="display:inline;">
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
            <div class="paginacion-personalizada">
                <!-- {{ $proyectos->links() }} -->
                {{ $proyectos->links('vendor.pagination.circular') }}
            </div>
        </div>
        </div>
    @endsection

</body>

</html>

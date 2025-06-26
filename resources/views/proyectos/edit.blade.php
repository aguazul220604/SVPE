@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Proyecto</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('proyectos.update', $proyecto->IdProyecto) }}">
        @csrf
        @method('PUT')
        
        <div class="section">
            <div class="section-title">Proyecto</div>
            <div class="grid-2">
                <label>
                    Usuario líder
                    <select name="IdUsuarioLider" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($lideres as $lider)
                            <option value="{{ $lider->IdUsuario }}" {{ $proyecto->IdUsuarioLider == $lider->IdUsuario ? 'selected' : '' }}>
                                {{ $lider->Nombre }} ({{ $lider->Matricula }})
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Categoría
                    <select name="IdCategoria" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->IdCategoria }}" {{ $proyecto->IdCategoria == $categoria->IdCategoria ? 'selected' : '' }}>
                                {{ $categoria->Descripcion }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Estatus
                    <select name="IdStatus" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($estatus as $status)
                            <option value="{{ $status->IdStatus }}" {{ $proyecto->descripcion->IdStatus == $status->IdStatus ? 'selected' : '' }}>
                                {{ $status->Descripcion }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Asesor
                    <select name="IdAsesor">
                        <option value="">Seleccione una opción</option>
                        @foreach($asesores as $asesor)
                            <option value="{{ $asesor->IdUsuario }}">
                                {{ $asesor->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Descripción</div>
            <div class="grid-2">
                <label>
                    Nombre
                    <input type="text" name="Nombre" value="{{ $proyecto->descripcion->Nombre }}" required>
                </label>
                <label>
                    Propuesta
                    <input type="text" name="PropValor" value="{{ $proyecto->descripcion->PropValor }}" required>
                </label>
            </div>

            <div class="grid-3">
                <label>
                    Introducción
                    <textarea name="Introduccion" required>{{ $proyecto->descripcion->Introduccion }}</textarea>
                </label>
                <label>
                    Justificación
                    <textarea name="Justificacion" required>{{ $proyecto->descripcion->Justificacion }}</textarea>
                </label>
                <label>
                    Descripción
                    <textarea name="Descripcion" required>{{ $proyecto->descripcion->Descripcion }}</textarea>
                </label>
                <label>
                    Objetivos Generales
                    <textarea name="ObjsGrals" required>{{ $proyecto->descripcion->ObjsGrals }}</textarea>
                </label>
                <label>
                    Objetivos Específicos
                    <textarea name="ObjsEspec" required>{{ $proyecto->descripcion->ObjsEspec }}</textarea>
                </label>
                <label>
                    Estado del arte
                    <textarea name="EdoArte" required>{{ $proyecto->descripcion->EdoArte }}</textarea>
                </label>
            </div>
            
            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
                <a href="{{ route('proyectos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection
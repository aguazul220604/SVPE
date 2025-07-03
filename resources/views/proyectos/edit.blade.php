@extends('layouts.app')

@section('content')
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .actions {
            margin-top: 20px;
            text-align: right;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
<div class="container">
    <h1>Editar proyecto</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('proyectos.update', $proyecto->IdProyecto) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="section">
            <div class="section-title">Información básica</div>
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
                            <option value="{{ $status->IdStatus }}" {{ $proyecto->IdStatus == $status->IdStatus ? 'selected' : '' }}>
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
                            <option value="{{ $asesor->IdUsuario }}" {{ $proyecto->IdAsesor == $asesor->IdUsuario ? 'selected' : '' }}>
                                {{ $asesor->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Documentación del proyecto</div>
            <div class="grid-2">
                <label>
                    Nombre del proyecto
                    <input type="text" name="Nombre" value="{{ $proyecto->descripcion->Nombre ?? '' }}" required>
                </label>
                <label>
                    Propuesta de valor
                    <input type="text" name="PropValor" value="{{ $proyecto->descripcion->PropValor ?? '' }}" required>
                </label>
            </div>

            <div class="grid-3">
                <label>
                    Introducción
                    <textarea name="Introduccion">{{ $proyecto->descripcion->Introduccion ?? '' }}</textarea>
                </label>
                <label>
                    Justificación
                    <textarea name="Justificacion">{{ $proyecto->descripcion->Justificacion ?? '' }}</textarea>
                </label>
                <label>
                    Descripción
                    <textarea name="Descripcion">{{ $proyecto->descripcion->Descripcion ?? '' }}</textarea>
                </label>
                <label>
                    Objetivos Generales
                    <textarea name="ObjsGrals">{{ $proyecto->descripcion->ObjsGrals ?? '' }}</textarea>
                </label>
                <label>
                    Objetivos Específicos
                    <textarea name="ObjsEspec">{{ $proyecto->descripcion->ObjsEspec ?? '' }}</textarea>
                </label>
                <label>
                    Estado del arte
                    <textarea name="EdoArte">{{ $proyecto->descripcion->EdoArte ?? '' }}</textarea>
                </label>
              
                <label>
                    Fortalezas
                    <textarea name="Fortalezas">{{ $proyecto->descripcion->Fortalezas ?? '' }}</textarea>
                </label>
                <label>
                    Oportunidades
                    <textarea name="Oportunidades">{{ $proyecto->descripcion->Oportunidades ?? '' }}</textarea>
                </label>
                <label>
                    Debilidades
                    <textarea name="Debilidades">{{ $proyecto->descripcion->Debilidades ?? '' }}</textarea>
                </label>
                <label>
                    Amenazas
                    <textarea name="Amenazas">{{ $proyecto->descripcion->Amenazas ?? '' }}</textarea>
                </label>
                <label>
                    Metodologías
                    <textarea name="Metodologias">{{ $proyecto->descripcion->Metodologias ?? '' }}</textarea>
                </label>
                <label>
                    Costos
                    <textarea name="Costos">{{ $proyecto->descripcion->Costos ?? '' }}</textarea>
                </label>
                <label>
                    Resultados
                    <textarea name="Resultados">{{ $proyecto->descripcion->Resultados ?? '' }}</textarea>
                </label>
                <label>
                    Referencias
                    <textarea name="Referencias">{{ $proyecto->descripcion->Referencias ?? '' }}</textarea>
                </label>
            </div>
            
            <div style="margin-top: 20px;">
                <label>
                    Documento PDF
                    <input type="file" name="pdf" accept=".pdf">
                    <small>Sube el documento completo del proyecto en formato PDF</small>
                    @if(isset($proyecto->descripcion->pdf_path))
                        <div style="margin-top:8px;">
                            <a href="{{ asset('storage/' . $proyecto->descripcion->pdf_path) }}" target="_blank">Ver PDF actual</a>
                        </div>
                    @endif
                </label>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('proyectos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
        </div>
    </form>
</div>
@endsection
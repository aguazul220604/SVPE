<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo proyecto</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
           color: #f73878;
            border-bottom: 2px solid #dee2e6;
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
            gap: 30px; /* Puedes ajustar este valor */
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
            a.btn {
        text-decoration: none;
        display: inline-block;
            }

        .btn-outline {
            background-color: white;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background-color: #f2f2f2;
        }
         .guardar{
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
         .guardar:hover {
        background-color: #db386e;
        color: white;
        text-decoration: none;
        }
         .btn-cancelar{
        color: #ffffff;
        background-color: #6C757D;
        border-radius: 8px;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-right: 20px;
        }
         .btn-cancelar:hover {
        background-color: #5f6365;
        color: white;
        text-decoration: none;
        }
        .boton-proyecto{
        border: 1px solid #f73878;
         color: #f73878;
        background-color: transparent;
        border-radius: 8px;
        padding: 11px 18px;
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
    </style>
</head>
<body>
@extends('layouts.app')

@section('content')
<h2>Nuevo proyecto</h2>
@if (session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="padding: 10px; background-color: #fff3cd; color: #856404; border-radius: 4px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('proyectos.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="section">
        <div class="section-title">Información específica</div>
        <div class="grid-2">
            <label>
                Usuario líder
                <select name="IdUsuarioLider" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($lideres as $lider)
                        <option value="{{ $lider->IdUsuario }}">{{ $lider->Nombre }} ({{ $lider->Matricula }})</option>
                    @endforeach
                </select>
            </label>
            <label>
                Categoría
                <select name="IdCategoria" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->IdCategoria }}">{{ $categoria->Descripcion }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Estatus
                <select name="IdStatus" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($estatus as $status)
                        <option value="{{ $status->IdStatus }}">{{ $status->Descripcion }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Asesor
                <select name="IdAsesor">
                    <option value="">Seleccione una opción</option>
                    @foreach($asesores as $asesor)
                        <option value="{{ $asesor->IdUsuario }}">{{ $asesor->Nombre }}</option>
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
                <input type="text" name="Nombre" placeholder="Nombre del proyecto" required>
            </label>
            <label>
                Propuesta de valor
                <input type="text" name="PropValor" placeholder="Propuesta de valor" required>
            </label>
        </div>

        <div class="grid-2">
            <label>
                Introducción
                <textarea name="Introduccion"></textarea>
            </label>
            <label>
                Justificación
                <textarea name="Justificacion"></textarea>
            </label>
            <label>
                Descripción
                <textarea name="Descripcion"></textarea>
            </label>
            <label>
                Objetivos Generales
                <textarea name="ObjsGrals"></textarea>
            </label>
            <label>
                Objetivos Específicos
                <textarea name="ObjsEspec"></textarea>
            </label>
            <label>
                Estado del arte
                <textarea name="EdoArte"></textarea>
            </label>
            <label>
                Fortalezas
                <textarea name="Fortalezas"></textarea>
            </label>
                <label>
                Oportunidades
                <textarea name="Oportunidades"></textarea>
            </label>
                 <label>
                Debilidades
                <textarea name="Debilidades"></textarea>
            </label>
            <label>
                Amenazas
                <textarea name="Amenazas"></textarea>
            </label>
             <label>
                Metodologías
                <textarea name="Metodologias"></textarea>
            </label>
             <label>
                Costos
                <textarea name="Costos"></textarea>
            </label>
            <label>
                Resultados
                <textarea name="Resultados"></textarea>
            </label>
             <label>
                Referencias
                <textarea name="Referencias"></textarea>
            </label>
        </div>
        
        <div style="margin-top: 20px;">
            <label>
                Documento PDF
                <input type="file" name="pdf" accept=".pdf" required>
                <small>Sube el documento completo del proyecto en formato PDF</small>
            </label>
        </div>
    </div>

    <div class="actions">
        <a href="{{ route('proyectos.index') }}" class="btn-cancelar">Cancelar</a>
        <button type="submit" class="guardar">Guardar Proyecto</button>
        <a href="#" class="boton-proyecto" id="generarPdfBtn">Generar PDF</a>

    </div>
</form>

<!-- <script src="{{ asset('js/pdf.js') }}"></script> -->
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('generarPdfBtn');
    if (!btn) return;

    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const jsPDF = window.jspdf.jsPDF;
        const doc = new jsPDF();

        const titulo = document.querySelector('input[name="Nombre"]')?.value.trim() || 'Proyecto sin título';

        const fecha = new Date().toLocaleDateString();

        // Encabezado
        let y = 15;
        doc.setFontSize(18);
        doc.setFont("helvetica", "bold");
        doc.text("Documentación del Proyecto", 10, y);
        y += 10;

        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        doc.text("Título: " + titulo, 10, y);
        y += 7;

        doc.text("Fecha de generación: " + fecha, 10, y);
        doc.line(10, y + 2, 200, y + 2); // línea divisoria
        y += 12;

        const campos = [
            { label: "Nombre del proyecto", name: "Nombre" },
            { label: "Propuesta de valor", name: "PropValor" },
            { label: "Introducción", name: "Introduccion" },
            { label: "Justificación", name: "Justificacion" },
            { label: "Descripción", name: "Descripcion" },
            { label: "Objetivos Generales", name: "ObjsGrals" },
            { label: "Objetivos Específicos", name: "ObjsEspec" },
            { label: "Estado del arte", name: "EdoArte" },
            { label: "Fortalezas", name: "Fortalezas" },
            { label: "Oportunidades", name: "Oportunidades" },
            { label: "Debilidades", name: "Debilidades" },
            { label: "Amenazas", name: "Amenazas" },
            { label: "Metodologías", name: "Metodologias" },
            { label: "Costos", name: "Costos" },
            { label: "Resultados", name: "Resultados" },
            { label: "Referencias", name: "Referencias" }
        ];

      
        campos.forEach(campo => {
            const valor = document.querySelector(`[name="${campo.name}"]`)?.value.trim() || "Sin contenido";

            doc.setFont("helvetica", "bold");
            doc.setFontSize(12);
            doc.text(campo.label + ":", 10, y);
            y += 7;

            doc.setFont("helvetica", "normal");
            doc.setFontSize(11);
            const lines = doc.splitTextToSize(valor, 180);
            doc.text(lines, 15, y);
            y += lines.length * 7 + 5;

            // Saltar de página si se pasa del límite
            if (y > 270) {
                doc.addPage();
                y = 20;
            }
        });

        // Pie de página con numeración
        const totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            doc.setFontSize(10);
            doc.text(`Página ${i} de ${totalPages}`, 180, 290);
        }

      
        //doc.save("proyecto.pdf");
        const nombreArchivo = titulo.replace(/\s+/g, '_') + ".pdf"; 
        doc.save(nombreArchivo);

    });
});
</script>
@endsection
</body>
</html>
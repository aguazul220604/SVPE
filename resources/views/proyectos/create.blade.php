<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo proyecto</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/proyectos/create.css') }}">
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

        <form method="POST" action="{{ route('proyectos.store') }}" enctype="multipart/form-data"
            class="formulario-principal">
            @csrf
            <div class="section">
                <div class="section-title">Información específica</div>
                <div class="grid-2">
                    <label>
                        Usuario líder
                        <select name="IdUsuarioLider" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($lideres as $lider)
                                <option value="{{ $lider->idUsuario }}">{{ $lider->nombres }}{{ $lider->apellido_paterno }}
                                    ({{ $lider->matricula }})
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        Categoría de convocatoria
                        <select name="IdCategoria" id="IdCategoria" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->idCategoria }}">{{ $categoria->descripcion }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>

                        Convocatoria
                        <select name="IdConvocatoria" id="IdConvocatoria" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                        </select>
                    </label>
                    <label>
                        Estatus
                        <select name="IdEstado" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($estatus as $status)
                                <option value="{{ $status->idEstado }}">{{ $status->nombre }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        Asesor
                        <select name="IdAsesor">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($asesores as $asesor)
                                <option value="{{ $asesor->idUsuario }}">
                                    {{ $asesor->nombres }}{{ $lider->apellido_paterno }} </option>
                            @endforeach
                        </select>
                    </label>

                    <!-- lista -->

                </div>
            </div>
            <div class="section">
                <div class="section-title">Integrantes</div>
                <div class="grid-2">

                    <label>
                        Agregar participantes
                        <button onclick="abrirModal()" class="guardar"style="text-align: right;">Seleccionar </button>
                        <div id="previewParticipantes">
                            <ul class="listado" id="listaParticipantes"></ul>
                        </div>
                    </label>
                    <!-- Modal -->
                    <div class="modal" id="miModal">
                        <div class="modal-cont">
                            <span class="close-btn" onclick="cerrarModal()">&times;</span>
                            <div class="modal-header">Seleccionar Participantes</div>

                            <div class="alert" id="alertaLimite"
                                style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
                                Solo puedes seleccionar un máximo de 4 participantes.</div>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Matrícula</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaParticipantes">
                                    <!-- Datos se llenan con JS -->
                                </tbody>
                            </table>
                            <button type="button" class="boton-proyecto" onclick="aceptarParticipantes()">Aceptar</button>
                            <div style="margin-top: 15px; text-align: right;">
                            </div>
                        </div>
                    </div>

                    <label>
                        Agregar colaboradores
                        <button onclick="abrirColaboradores()" class="guardar"
                            style="text-align: right;">Seleccionar</button>
                        <div id="previewColaboradores">
                            <ul class="listado" id="listaColaboradores"></ul>
                        </div>
                    </label>

                    <div class="modal" id="miModalito">
                        <div class="modal-cont">
                            <span class="close-btn" onclick="cerrarModalito()">&times;</span>
                            <div class="modal-header">Seleccionar Colaboradores</div>

                            <div class="alert" id="alertaLimite"
                                style="display:none; padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
                                Solo puedes seleccionar un máximo de 4 colaboradores.
                            </div>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Matrícula</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaColaboradores">
                                    <!-- Datos se llenan con JS -->
                                </tbody>
                            </table>

                            <button type="button" class="boton-proyecto" onclick="aceptarColaboradores()">Aceptar</button>
                        </div>
                    </div>
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
                        ¿Recibe financiamiento?<br>
                        <input type="checkbox" id="recibeFinanciamiento" name="Financiamiento">
                        <div id="tiposFinanciamientoContainer" style="display: none; margin-top: 10px;">
                            <label>
                                Tipo de financiamiento
                                <select name="financiamiento" id="tipoFinanciamiento">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="0">Interno</option>
                                    <option value="1">Externo</option>
                                </select>
                            </label>
                        </div>
                    </label>
                    <label>
                        Monto
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
                <!-- se mostrarar la previsuaiacion de archivo  -->
                <div id="pdfPreview" style="margin-top: 15px; display: none;">
                    <p><strong>Vista previa del PDF:</strong></p>
                    <iframe id="pdfViewer" width="100%" height="400px"></iframe>
                </div>
                <div style="margin-top: 20px;">
                    <label>
                        Documento PDF
                        <input type="file" name="pdf" accept=".pdf" id="pdfInput" required>
                        <small>Sube el documento completo del proyecto en formato PDF. Tamaño máximo: 3 MB</small>
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
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('generarPdfBtn');
                if (!btn) {
                    console.warn("No se encontró el botón con id 'generarPdfBtn'");
                    return;
                }

                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const jsPDF = window.jspdf.jsPDF;
                    const doc = new jsPDF();

                    const titulo = document.querySelector('input[name="Nombre"]')?.value.trim() ||
                        'Proyecto sin título';
                    const fecha = new Date().toLocaleDateString();

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
                    doc.line(10, y + 2, 200, y + 2);
                    y += 12;

                    const campos = [{
                            label: "Nombre del proyecto",
                            name: "Nombre"
                        },
                        {
                            label: "Propuesta de valor",
                            name: "PropValor"
                        },
                        {
                            label: "Introducción",
                            name: "Introduccion"
                        },
                        {
                            label: "Justificación",
                            name: "Justificacion"
                        },
                        {
                            label: "Descripción",
                            name: "Descripcion"
                        },
                        {
                            label: "Objetivos Generales",
                            name: "ObjsGrals"
                        },
                        {
                            label: "Objetivos Específicos",
                            name: "ObjsEspec"
                        },
                        {
                            label: "Estado del arte",
                            name: "EdoArte"
                        },
                        {
                            label: "Fortalezas",
                            name: "Fortalezas"
                        },
                        {
                            label: "Oportunidades",
                            name: "Oportunidades"
                        },
                        {
                            label: "Debilidades",
                            name: "Debilidades"
                        },
                        {
                            label: "Amenazas",
                            name: "Amenazas"
                        },
                        {
                            label: "Metodologías",
                            name: "Metodologias"
                        },
                        {
                            label: "Costos",
                            name: "Costos"
                        },
                        {
                            label: "Resultados",
                            name: "Resultados"
                        },
                        {
                            label: "Referencias",
                            name: "Referencias"
                        }
                    ];

                    campos.forEach(campo => {
                        const valor = document.querySelector(`[name="${campo.name}"]`)?.value.trim();
                        if (!valor) return;

                        doc.setFont("helvetica", "bold");
                        doc.setFontSize(12);
                        doc.text(campo.label + ":", 10, y);
                        y += 7;

                        doc.setFont("helvetica", "normal");
                        doc.setFontSize(11);
                        const lines = doc.splitTextToSize(valor, 180);
                        doc.text(lines, 15, y);
                        y += lines.length * 7 + 5;

                        if (y > 270) {
                            doc.addPage();
                            y = 20;
                        }
                    });

                    const totalPages = doc.internal.getNumberOfPages();
                    for (let i = 1; i <= totalPages; i++) {
                        doc.setPage(i);
                        doc.setFontSize(10);
                        doc.text(`Página ${i} de ${totalPages}`, 180, 290);
                    }

                    const nombreArchivo = titulo.replace(/\s+/g, '_') + ".pdf";
                    doc.save(nombreArchivo);
                });
            });
        </script>
        <script>
            document.getElementById('pdfInput').addEventListener('change', function(e) {
                const file = e.target.files[0];

                const maxSizeMB = 1;
                const maxSizeBytes = maxSizeMB * 1024 * 1024;

                if (!file) return;

                if (file.type !== "application/pdf") {
                    alert("Solo se permite subir archivos en formato PDF.");
                    e.target.value = "";
                    document.getElementById('pdfPreview').style.display = 'none';
                    return;
                }

                if (file.size > maxSizeBytes) {
                    alert("El archivo PDF no debe superar los 3 MB.");
                    e.target.value = "";
                    document.getElementById('pdfPreview').style.display = 'none';
                    return;
                }

                const fileURL = URL.createObjectURL(file);
                document.getElementById('pdfViewer').src = fileURL;
                document.getElementById('pdfPreview').style.display = 'block';
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('recibeFinanciamiento');
                const container = document.getElementById('tiposFinanciamientoContainer');

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                    }
                });
            });
        </script>
        <script>
            document.getElementById('IdCategoria').addEventListener('change', function() {
                const categoriaId = this.value;
                const convocatoriaSelect = document.getElementById('IdConvocatoria');
                convocatoriaSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`/convocatorias-por-categoria/${categoriaId}`)
                    .then(response => response.json())
                    .then(data => {
                        convocatoriaSelect.innerHTML =
                            '<option value="" selected disabled>Seleccione una opción</option>';
                        data.forEach(convocatoria => {
                            const option = document.createElement('option');
                            option.value = convocatoria.idConvocatoria;
                            option.textContent = convocatoria.nombre;
                            convocatoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        convocatoriaSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            });
        </script>
        <script>
            const participantes = @json($participantes);
            const modal = document.getElementById('miModal');
            const tabla = document.getElementById('tablaParticipantes');
            const alerta = document.getElementById('alertaLimite');
            const listaPreview = document.getElementById('listaParticipantes');

            function abrirModal() {
                alerta.style.display = 'none';
                tabla.innerHTML = ''; // Limpiar la tabla
                participantes.forEach((p, i) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
    <td><input type="checkbox" class="check-participante" value="${p.idUsuario}" data-nombre="${p.nombres}" data-apellido="${p.apellido_paterno}" data-matricula="${p.matricula}"></td>
      <td>${p.matricula}</td>
      <td>${p.nombres}</td>
      <td>${p.apellido_paterno}</td>
    `;
                    tabla.appendChild(row);
                });
                modal.style.display = 'block';
            }

            function cerrarModal() {
                modal.style.display = 'none';
            }

            function validarSeleccion() {
                const seleccionados = document.querySelectorAll('.check-participante:checked');
                if (seleccionados > 4) {
                    alerta.style.display = 'block';
                    // Desmarcar el último que seleccionó
                    this.checked = false;
                } else {
                    alerta.style.display = 'none';
                }
            }

            function aceptarParticipantes() {
                const seleccionados = document.querySelectorAll('.check-participante:checked');
                if (seleccionados.length > 4) {
                    alerta.style.display = 'block';
                    return;
                }

                const form = document.querySelector('form.formulario-principal');

                // Limpiar previos
                listaPreview.innerHTML = '';
                const antiguosInputs = form.querySelectorAll('input[name^="participantes["]');
                antiguosInputs.forEach(input => input.remove());

                seleccionados.forEach((checkbox, index) => {
                    const idUsuario = checkbox.value;
                    const nombre = checkbox.getAttribute('data-nombre');
                    const matricula = checkbox.getAttribute('data-matricula');
                    const apellido = checkbox.getAttribute('data-apellido'); // nuevo

                    const li = document.createElement('li');
                    li.textContent = `${matricula} - ${nombre}${apellido} `;
                    listaPreview.appendChild(li);

                    // Generar inputs ocultos
                    const fields = {
                        idUsuario: idUsuario,
                        idProyecto: null, // cambiado para evitar error
                        lider: 0,
                        nivel: 1,
                        tipo_participacion: 'autor'
                    };

                    for (const key in fields) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `participantes[${index}][${key}]`;
                        input.value = fields[key];
                        form.appendChild(input);
                    }
                });

                cerrarModal();
            }

            // Limitar selección
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('check-participante')) {
                    const checks = document.querySelectorAll('.check-participante:checked');
                    if (checks.length > 4) {
                        e.target.checked = false;
                        alerta.style.display = 'block';
                        setTimeout(() => {
                            alerta.style.display = 'none';
                        }, 3000);
                    }
                }
            });
        </script>
        <script>
            document.querySelector('form').addEventListener('submit', function() {
                const select = document.getElementById('tipoFinanciamiento');
                if (select.value === 'Interno') select.value = '0';
                if (select.value === 'Externo') select.value = '1';
            });
        </script>

        <script>
            // Datos de colaboradores desde backend (Laravel Blade)
            const colaboradores = @json($colaboradores);

            // Elementos DOM
            const miModalito = document.getElementById('miModalito');
            const tablaColaboradores = document.getElementById('tablaColaboradores');
            const alertaLimite = document.getElementById('alertaLimite');
            const listaColaboradores = document.getElementById('listaColaboradores');

            function abrirColaboradores() {
                alertaLimite.style.display = 'none';
                tablaColaboradores.innerHTML = ''; // limpiar tabla

                colaboradores.forEach(colaborador => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
      <td><input type="checkbox" class="check-colaborador" value="${colaborador.idColaborador}" 
        data-nombres="${colaborador.nombres}" 
        data-apellido_paterno="${colaborador.apellido_paterno}" 
        data-apellido_materno="${colaborador.apellido_materno ?? ''}"
        data-matricula="${colaborador.matricula}"
        ></td>
      <td>${colaborador.matricula}</td>
      <td>${colaborador.nombres}</td>
      <td>${colaborador.apellido_paterno}</td>
    `;
                    tablaColaboradores.appendChild(row);
                });

                miModalito.style.display = 'block';
            }

            function cerrarModalito() {
                miModalito.style.display = 'none';
            }

            function aceptarColaboradores() {
                const seleccionados = tablaColaboradores.querySelectorAll('.check-colaborador:checked');
              
                const form = document.querySelector('form.formulario-principal');
                listaColaboradores.innerHTML = '';

                // Remover inputs ocultos previos de colaboradores
                const inputsPrevios = form.querySelectorAll('input[name^="colaboradores["]');
                inputsPrevios.forEach(input => input.remove());

                seleccionados.forEach((checkbox, index) => {
                    const idColaborador = checkbox.value;
                    const nombres = checkbox.getAttribute('data-nombres');
                    const apellido_paterno = checkbox.getAttribute('data-apellido_paterno');
                    const apellido_materno = checkbox.getAttribute('data-apellido_materno');
                    const matricula = checkbox.getAttribute('data-matricula');

                    // Mostrar en la lista de colaboradores seleccionados
                    const li = document.createElement('li');
                    li.textContent = `${matricula} - ${nombres} ${apellido_paterno}`;
                    listaColaboradores.appendChild(li);

                    // Crear inputs ocultos para enviar al backend
                    const fields = {
                        idColaborador: idColaborador,
                        nombres: nombres,
                        apellido_paterno: apellido_paterno,
                        apellido_materno: apellido_materno,
                        matricula: matricula,
                    };

                    for (const key in fields) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `colaboradores[${index}][${key}]`;
                        input.value = fields[key];
                        form.appendChild(input);
                    }
                });

                cerrarModalito();
            }
        </script>
        <script>
            document.getElementById('IdCategoria').addEventListener('change', function() {
                const categoriaId = this.value;
                const convocatoriaSelect = document.getElementById('IdConvocatoria');
                convocatoriaSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`/convocatorias-por-categoria/${categoriaId}`)
                    .then(response => response.json())
                    .then(data => {
                        convocatoriaSelect.innerHTML =
                            '<option value="" selected disabled>Seleccione una opción</option>';
                        data.forEach(convocatoria => {
                            const option = document.createElement('option');
                            option.value = convocatoria.idConvocatoria;
                            option.textContent = convocatoria.nombre;
                            convocatoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        convocatoriaSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            });
        </script>
    @endsection
</body>

</html>

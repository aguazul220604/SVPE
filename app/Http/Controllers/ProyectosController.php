<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Usuario;
use App\Models\Convocatoria;
use App\Models\Participantes;
use App\Models\Colaboradores;
use App\Models\ColaboradoresProyectos;
use App\Models\Estado_proyecto;
use App\Models\DescripcionProyecto;
use App\Models\Estatus;
use App\Models\ProyectoEliminado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProyectosController extends Controller
{
     public function index(Request $request)
{
    $buscar = $request->input('buscar');
    $userId = Auth::id();

    $proyectos = Proyecto::with(['convocatoria', 'descripcion'])
        ->where('idUsuario_Mod', $userId)
        ->when($buscar, function ($query, $buscar) {
            $query->where(function ($query) use ($buscar) {
                $query->whereHas('descripcion', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', '%' . $buscar . '%');
                })->orWhereHas('convocatoria', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', '%' . $buscar . '%');
                });
            });
        })
        ->orderBy('fecha_registro', 'desc')
        ->paginate(10)
        ->appends(['buscar' => $buscar]);

    return view('proyectos.index', compact('proyectos'));
}


    public function create()
    {
        $lideres = Usuario::where('IdRol', 2)->get();
        $categorias = Categoria::where('estatus', 1)->get();
        $estatus = Estatus::all();
        $asesores = Usuario::where('IdRol', 6)->get();
        $participantes = Usuario::where('IdRol', 3)->get();
        $colaboradores = Colaboradores::all();
        return view('proyectos.create', compact('lideres', 'categorias', 'estatus', 'asesores', 'participantes', 'colaboradores'));
    }

    public function edit($id)
    {
        $proyecto = Proyecto::with('descripcion')->findOrFail($id);

        $lideres = Usuario::where('IdRol', 2)->get();
        $categorias = Categoria::where('estatus', 1)->get();
        $estatus = Estatus::all();
        $asesores = Usuario::where('IdRol', 6)->get();

        // $participantes = 
         $participantes = Usuario::where('IdRol', 3)->get();
       
             $participanteSeleccionados = Participantes::with('usuario')
            ->where('IdProyecto', $id)
            ->get();

            $colaboradores =Colaboradores::all();

               $colaboradoresSeleccionados = Proyecto::find($id)
                ->colaboradores()
                ->select( 'nombres', 'apellido_paterno')
                ->get();


        $liderAsignado = Participantes::where('idProyecto', $id)
            ->where('lider', 1)
            ->where('tipo_participacion', 1)
            ->with('usuario')
            ->first();

        $asesorAsignado = Participantes::where('idProyecto', $id)
            ->where('tipo_participacion', 4)
            ->with('usuario')
            ->first();

        return view('proyectos.edit', compact(
            'proyecto',
            'lideres',
            'categorias',
            'estatus',
            'asesores',
            'participantes',
            'liderAsignado',
            'asesorAsignado',
            'colaboradores',
            'participanteSeleccionados',
            'colaboradoresSeleccionados'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'IdConvocatoria' => 'required|exists:convocatorias,idConvocatoria',
            'IdCategoria' => 'required|exists:disciplinas,idCategoria',
            'IdEstado' => 'required|exists:estados_proyectos,idEstado',
            'Nombre' => 'required|string|max:255',
            'PropValor' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:3072',
        ]);

        DB::beginTransaction();

        try {
            // Subir PDF
            $pdfPath = null;
            if ($request->hasFile('pdf')) {
                $pdfPath = $request->file('pdf')->store('proyectos', 'public');
            }


            // Crear la descripción del proyecto
            $descripcion = DescripcionProyecto::create([
                'nombre' => $request->Nombre,
                'propuesta_valor' => $request->PropValor,
                'introduccion' => $request->Introduccion,
                'justificacion' => $request->Justificacion,
                'descripcion' => $request->Descripcion,
                'objetivos_generales' => $request->ObjsGrals,
                'objetivos_especificos' => $request->ObjsEspec,
                'estado_arte' => $request->EdoArte,
                'fortalezas' => $request->Fortalezas,
                'oportunidades' => $request->Oportunidades,
                'debilidades' => $request->Debilidades,
                'amenazas' => $request->Amenazas,
                'metodologias' => $request->Metodologias,
                'costos' => $request->Costos,
                'resultados' => $request->Resultados,
                'referencias' => $request->Referencias,
                'pdf' => $pdfPath,
                'idEstado' => $request->IdEstado,
                'fecha_alta' => now(),
                'idUsuario_Alta' => Auth::id(),
            ]);

            // Crear el proyecto
            $proyecto = Proyecto::create([
                'idConvocatoria' => $request->IdConvocatoria,
                'idDescripcion' => $descripcion->idDescripcion_Proyecto,
                'fecha_registro' => now(),
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'fecha_mod' => now(),
                'financiamiento' => $request->financiamiento ?? null,
                'idUsuario_Mod' => Auth::id(),
            ]);

            // Guardar líderes si existen
            if ($request->filled('IdUsuarioLider')) {
                Participantes::create([
                    'idUsuario' => $request->IdUsuarioLider,
                    'idProyecto' => $proyecto->idProyecto,
                    'lider' => '1',
                    'nivel' => '2',
                    'tipo_participacion' => '1',
                ]);
            }

            // Guardar asesores si existen
            if ($request->filled('IdAsesor')) {
                Participantes::create([
                    'idUsuario' => $request->IdAsesor,
                    'idProyecto' => $proyecto->idProyecto,
                    'lider' => '0',
                    'nivel' => '2',
                    'tipo_participacion' => '4',
                ]);
            }

            // Guardar participantes si existen
            if ($request->has('participantes')) {
                foreach ($request->participantes as $participante) {
                    Participantes::create([
                        'idUsuario' => $participante['idUsuario'],
                        'idProyecto' => $proyecto->idProyecto,
                        'lider' => $participante['lider'],
                        'nivel' => $participante['nivel'],
                        'tipo_participacion' => '3',
                    ]);
                }
            }
           // guardar colaboradores si existen
            if ($request->has('colaboradores')) {
                foreach ($request->colaboradores as $colaborador) {
                    // Verificar si no existe ya la relación para evitar duplicados
                    $exists = ColaboradoresProyectos::where('idProyecto', $proyecto->idProyecto)
                        ->where('idColaborador', $colaborador['idColaborador'])
                        ->exists();

                    if (! $exists) {
                        ColaboradoresProyectos::create([
                            'idProyecto' => $proyecto->idProyecto,
                            'idColaborador' => $colaborador['idColaborador'],
                        ]);
                    }
                }
            }



            DB::commit();

            return redirect()->route('proyectos.index')->with('success', 'Proyecto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear el proyecto: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'IdUsuarioLider' => 'required|exists:usuarios,idUsuario',
            'IdCategoria' => 'required|exists:disciplinas,idCategoria',
            'IdEstado' => 'required|exists:estados_proyectos,idEstado',
            'Nombre' => 'required|string|max:255',
            'PropValor' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:3072',
            
        ]);

        DB::beginTransaction();

        try {
            $proyecto = Proyecto::findOrFail($id);

            // Actualizar campos del proyecto
            $proyecto->update([
                'IdUsuarioLider' => $request->IdUsuarioLider,
                'IdCategoria' => $request->IdCategoria,
                'FechaMod' => now(),
                'IdUsuarioMod' => Auth::id(),
                 'financiamiento' => $request->financiamiento ?? null,
            ]);

            // Procesar PDF si se sube
            $pdfData = [];

            if ($request->hasFile('pdf')) {
                if ($proyecto->descripcion->Pdf) {
                    Storage::disk('public')->delete($proyecto->descripcion->pdf);
                }

                $pdfPath = $request->file('pdf')->store('proyectos', 'public');
                $pdfData['pdf'] = $pdfPath;
            }

            // Actualizar descripción del proyecto
            $proyecto->descripcion->update(array_merge([
                'nombre' => $request->Nombre,
                'propuesta_valor' => $request->PropValor,
                'introduccion' => $request->Introduccion,
                'justificacion' => $request->Justificacion,
                'descripcion' => $request->Descripcion,
                'objetivos_generales' => $request->ObjsGrals,
                'objetivos_especificos' => $request->ObjsEspec,
                'estado_arte' => $request->EdoArte,
                'fortalezas' => $request->Fortalezas,
                'oportunidades' => $request->Oportunidades,
                'debilidades' => $request->Debilidades,
                'amenazas' => $request->Amenazas,
                'metodologias' => $request->Metodologias,
                'costos' => $request->Costos,
                'resultados' => $request->Resultados,
                'referencias' => $request->Referencias,
                'idEstado' => $request->IdEstado,
                'fecha_mod' => now(),
                'idUsuario_Mod' => auth()->id() ?? 1,
            ], $pdfData));

             // Actualizar participantes
                if ($request->has('participantes')) {
                    // Borrar los viejos
                    Participantes::where('idProyecto', $proyecto->idProyecto)->delete();

                    foreach ($request->participantes as $participante) {
                        Participantes::create([
                            'idUsuario' => $participante['idUsuario'],
                            'idProyecto' => $proyecto->idProyecto,
                            'lider' => $participante['lider'],
                            'nivel' => $participante['nivel'],
                            'tipo_participacion' => '3',
                        ]);
                    }
                }

                // Actualizar colaboradores
                if ($request->has('colaboradores')) {
                    ColaboradoresProyectos::where('idProyecto', $proyecto->idProyecto)->delete();

                    foreach ($request->colaboradores as $colaborador) {
                        ColaboradoresProyectos::create([
                            'idProyecto' => $proyecto->idProyecto,
                            'idColaborador' => $colaborador['idColaborador'],
                        ]);
                    }
                }


            DB::commit();

            return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $proyecto = Proyecto::with(['lider', 'descripcion.estado', 'categoria', 'estatus'])->findOrFail($id);
        $participantes = Participantes::with('usuario')
            ->where('IdProyecto', $id)
            ->get();

        // Obtener líderes
        $lideres = Participantes::with('usuario')
            ->where('IdProyecto', $id)
            ->where('lider', '1')
            ->first();

        // Traer asesor
        $asesores = Participantes::with('usuario')
            ->where('IdProyecto', $id)
            ->where('tipo_participacion', '4')
            ->first();

        $colaboradores = Proyecto::find($id)
            ->colaboradores()
            ->select('nombres', 'apellido_paterno')
            ->get();

        return view('proyectos.show', compact('proyecto', 'participantes', 'lideres', 'asesores','colaboradores'));
    }

    public function porCategoria($idCategoria)
    {
        $convocatorias = DB::table('convocatorias')
            ->join('pertenecen', 'convocatorias.idConvocatoria', '=', 'pertenecen.idConvocatoria')
            ->where('pertenecen.idCategoria', $idCategoria)
            ->select('convocatorias.idConvocatoria', 'convocatorias.nombre')
            ->get();

        return response()->json($convocatorias);
    }

    // Método para descargar el PDF
    public function downloadPdf($id)
    {
        $proyecto = Proyecto::with('descripcion')->findOrFail($id);

        if (!$proyecto->descripcion->Pdf) {
            return back()->with('error', 'El proyecto no tiene un documento PDF asociado.');
        }

        $path = storage_path('app/public/' . $proyecto->descripcion->Pdf);

        return response()->download($path, 'proyecto_' . $proyecto->descripcion->Nombre . '.pdf');
    }

    // Método para generar un PDF con los datos del proyecto
    public function generatePdf($id)
    {
        $proyecto = Proyecto::with(['descripcion'])->findOrFail($id);

        $pdf = \PDF::loadView('proyectos.pdf', compact('proyecto'));

        return $pdf->download('resumen_proyecto_' . $proyecto->descripcion->Nombre . '.pdf');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $proyecto = Proyecto::findOrFail($id);

            // Guardar en la tabla de proyectos eliminados
            ProyectoEliminado::create([
                'IdProyecto' => $proyecto->IdProyecto,
                'IdUsuario' => auth()->id() ?? 1,
                'FechaElimina' => now(),
            ]);

            // Eliminar el proyecto (las tablas hijas se eliminan automáticamente por ON DELETE CASCADE)
            $proyecto->delete();

            DB::commit();

            return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\TblUsuario;
use App\Models\Categoria;
use App\Models\Estatus;
use App\Models\DescripcionProyecto;
use App\Models\ProyectoEliminado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProyectosController extends Controller
{
public function index(Request $request)
{
    $buscar = $request->input('buscar');
    $userId = Auth::id(); // Usuario autenticado

    $proyectos = Proyecto::with(['lider', 'categoria', 'descripcion.estatus'])
        ->where('IdUsuarioMod', $userId) // filtramos por quien creó el proyecto
        ->when($buscar, function ($query, $buscar) {
            $query->where(function ($query) use ($buscar) {
                $query->whereHas('descripcion', function ($q) use ($buscar) {
                    $q->where('Nombre', 'like', '%' . $buscar . '%');
                })->orWhereHas('lider', function ($q) use ($buscar) {
                    $q->where('Nombre', 'like', '%' . $buscar . '%');
                })->orWhereHas('categoria', function ($q) use ($buscar) {
                    $q->where('Descripcion', 'like', '%' . $buscar . '%');
                });
            });
        })
        // ->get();
        ->paginate(5);
        // ->appends(['buscar' => $buscar]);
    return view('proyectos.index', compact('proyectos'));
}


    public function create()
    {
        $lideres = TblUsuario::where('IdRol', 2)->get();
        $categorias = Categoria::where('Estatus', 1)->get();
        $estatus = Estatus::where('Catalogo', 'Proyectos')->get();
        $asesores = TblUsuario::where('IdRol', 6)->get();

        return view('proyectos.create', compact('lideres', 'categorias', 'estatus', 'asesores'));
    }
    
     public function show($id)
    {
        $proyecto = Proyecto::with(['lider', 'categoria', 'descripcion', 'integrantes'])->findOrFail($id);
        return view('proyectos.show', compact('proyecto'));
    }

    public function edit($id)
    {
        $proyecto = Proyecto::with('descripcion')->findOrFail($id);
        $lideres = TblUsuario::where('IdRol', 2)->get();
        $categorias = Categoria::where('Estatus', 1)->get();
        $estatus = Estatus::where('Catalogo', 'Proyectos')->get();
        $asesores = TblUsuario::where('IdRol', 6)->get();

        return view('proyectos.edit', compact('proyecto', 'lideres', 'categorias', 'estatus', 'asesores'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'IdUsuarioLider' => 'required|exists:Tblusuario,IdUsuario',
            'IdCategoria' => 'required|exists:Catcategoria,IdCategoria',
            'IdStatus' => 'required|exists:Catestatus,IdStatus',
            'Nombre' => 'required|string|max:255',
            'PropValor' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {
               $pdfPath = null;
            // Procesar el archivo PDF
            // $pdfPath = $request->file('pdf')->store('proyectos', 'public');
             if ($request->hasFile('pdf')) {
                 $pdfPath = $request->file('pdf')->store('proyectos', 'public');
                }


            // Crear la descripción del proyecto
            $descripcion = DescripcionProyecto::create([
                'Nombre' => $request->Nombre,
                'PropValor' => $request->PropValor,
                'Introduccion' => $request->Introduccion,
                'Justificacion' => $request->Justificacion,
                'Descripcion' => $request->Descripcion,
                'ObjsGrals' => $request->ObjsGrals,
                'ObjsEspec' => $request->ObjsEspec,
                'EdoArte' => $request->EdoArte,
                'Fortalezas'=>$request->Fortalezas,
                'Oportunidades'=>$request->Oportunidades,
                'Debilidades'=>$request->Debilidades,
                'Amenazas'=>$request->Amenazas,
                'Metodologias'=>$request->Metodologias,
                'Costos'=>$request->Costos,
                'Resultados'=>$request->Resultados,
                'Referencias'=>$request->Referencias,
                'Pdf' => $pdfPath,
                'IdStatus' => $request->IdStatus,
                'FechaAlta' => now(),
                'IdUsuarioAlta' => Auth::id(),
            ]);

            $proyecto = Proyecto::create([
                'IdUsuarioLider' => $request->IdUsuarioLider,
                'IdCategoria' => $request->IdCategoria,
                'IdDescripcion' => $descripcion->IdDescProyecto,
                'FechaAlta' => now(),
                'FechaMod' => now(),
                'IdUsuarioMod' => Auth::id(),
            ]);

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
        'IdUsuarioLider' => 'required|exists:Tblusuario,IdUsuario',
        'IdCategoria' => 'required|exists:catcategoria,IdCategoria',
        'IdStatus' => 'required|exists:catestatus,IdStatus',
        'Nombre' => 'required|string|max:255',
        'PropValor' => 'required|string|max:255',
        'pdf' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    DB::beginTransaction();

    try {
        $proyecto = Proyecto::findOrFail($id);

        // Actualiza los datos del proyecto
        $proyecto->update([
            'IdUsuarioLider' => $request->IdUsuarioLider,
            'IdCategoria' => $request->IdCategoria,
            'FechaMod' => now(),
            'IdUsuarioMod' => Auth::id(),
        ]);

        // Procesar el PDF (si se subió uno)
        $pdfData = [];

        if ($request->hasFile('pdf')) {
            // Eliminar PDF anterior
            if ($proyecto->descripcion->Pdf) {
                Storage::disk('public')->delete($proyecto->descripcion->Pdf);
            }

            // Guardar nuevo PDF
            $pdfPath = $request->file('pdf')->store('proyectos', 'public');
            $pdfData['Pdf'] = $pdfPath;
        }

        // Actualizar la descripción del proyecto
        $proyecto->descripcion->update(array_merge([
            'Nombre' => $request->Nombre,
            'PropValor' => $request->PropValor,
            'Introduccion' => $request->Introduccion,
            'Justificacion' => $request->Justificacion,
            'Descripcion' => $request->Descripcion,
            'ObjsGrals' => $request->ObjsGrals,
            'ObjsEspec' => $request->ObjsEspec,
            'EdoArte' => $request->EdoArte,
            'Fortalezas' => $request->Fortalezas,
            'Oportunidades' => $request->Oportunidades,
            'Debilidades' => $request->Debilidades,
            'Amenazas' => $request->Amenazas,
            'Metodologias' => $request->Metodologias,
            'Costos' => $request->Costos,
            'Resultados' => $request->Resultados,
            'Referencias' => $request->Referencias,
            'IdStatus' => $request->IdStatus,
            'FechaMod' => now(),
            'IdUsuarioMod' => auth()->id() ?? 1,
        ], $pdfData));

        DB::commit();

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
    }
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
        $proyecto = Proyecto::with(['lider', 'categoria', 'descripcion'])->findOrFail($id);
        
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
            'IdProyecto'     => $proyecto->IdProyecto,
            'IdUsuario'      => auth()->id() ?? 1,
            'FechaElimina'   => now(),
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


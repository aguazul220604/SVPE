<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\Proyecto;
use App\Models\Estatus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Participantes;

class MonitoreoController extends Controller
{
    public function index(Request $request)
    {
        $estatus = $request->input('estatus', 'TODOS');
        $convocatoriaId = $request->input('convocatoria');

        $proyectos = Proyecto::with([
            'lider',
            'descripcion.estado',
            'convocatoria'
        ])
            ->when($estatus != 'TODOS', function ($query) use ($estatus) {
                $query->whereHas('descripcion.estado', function ($q) use ($estatus) {
                    $q->where('idEstado', $estatus);
                });
            })
            ->when($convocatoriaId, function ($query) use ($convocatoriaId) {
                $query->where('idConvocatoria', $convocatoriaId);
            })
            ->orderByDesc('fecha_registro')
            ->paginate(10);

        $estatusDisponibles = Estatus::all();
        $convocatoriaActual = $convocatoriaId ? Convocatoria::find($convocatoriaId) : null;

        return view('monitoreo.index', [
            'proyectos' => $proyectos,
            'estatus' => $estatus,
            'estatusDisponibles' => $estatusDisponibles,
            'convocatoriaActual' => $convocatoriaActual
        ]);
    }

    public function proyectosPorConvocatoria($convocatoriaId)
    {
        return redirect()->route('monitoreo.index', [
            'convocatoria' => $convocatoriaId
        ]);
    }

    public function convocatorias(Request $request)
    {
        $estatusFiltro = $request->input('estatus', 'TODAS');

        $convocatorias = Convocatoria::with([
            'proyectos' => function ($query) {
                $query->orderBy('fecha_registro', 'desc')
                    ->with(['lider', 'descripcion.estado']);
            },
            'estado'
        ])
            ->when($estatusFiltro != 'TODAS', function ($query) use ($estatusFiltro) {
                $query->whereHas('estado', function ($q) use ($estatusFiltro) {
                    $q->where('descripcion', $estatusFiltro);
                });
            })
            ->orderByDesc('fecha_inicio')
            ->paginate(10);

        return view('monitoreo.convocatorias', [
            'convocatorias' => $convocatorias,
            'estatus' => $estatusFiltro
        ]);
    }
public function show2($id)
{
    $proyecto = Proyecto::with(['lider','descripcion.estado', 'categoria','estatus'])->findOrFail($id);
    $participantes = Participantes::with('usuario')
        ->where('IdProyecto', $id)
        ->get();

    $lideres = Participantes::with('usuario')
        ->where('IdProyecto', $id)  
        ->where('lider', '1')
        ->first();

    $asesores = Participantes::with('usuario')
        ->where('IdProyecto', $id)  
        ->where('tipo_participacion', '4')
        ->first();
  $colaboradores = Proyecto::find($id)
            ->colaboradores()
            ->select('nombres', 'apellido_paterno')
            ->get();

    // Guardar la URL previa en sesión si viene de una ruta válida
    if (strpos(url()->previous(), 'monitoreo') !== false || strpos(url()->previous(), 'convocatorias') !== false) {
        session(['previous_url' => url()->previous()]);
    }

    return view('monitoreo.show2', compact('proyecto','participantes','lideres','asesores','colaboradores'));
}
    public function show($id)
    {
        $proyecto = Proyecto::with([
            'lider',
            'descripcion.estado',
            'convocatoria',
            'actividades' => function ($query) {
                $query->orderBy('fecha_inicio', 'desc');
            }
        ])->findOrFail($id);

        return view('proyecto.show', compact('proyecto'));
    }

    public function updateStatus(Request $request, $proyectoId)
    {
        $request->validate([
            'estatus' => 'required|exists:estados_proyectos,idEstado'
        ]);

        $proyecto = Proyecto::findOrFail($proyectoId);

        $proyecto->descripcion()->update([
            'idEstado' => $request->estatus,
            'fecha_mod' => now(),
            'idUsuario_Mod' => auth()->id()
        ]);

        return back()->with('success', 'Estado actualizado correctamente');
    }
}

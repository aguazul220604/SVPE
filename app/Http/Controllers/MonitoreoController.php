<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoreoController extends Controller
{
    public function index(Request $request)
    {
        $estatus = $request->input('estatus', 'TODAS');
        $today = Carbon::today();
        
        $convocatorias = Convocatoria::with([
            'categoria', 
            'estatus', 
            'proyectosConvocatoria' => function($query) {
                $query->with([
                    'proyecto.descripcion', 
                    'proyecto.lider.carrera', 
                    'usuarioPostula'
                ]);
            }
        ])
        ->where('Estatus', 1)
        ->when($estatus == 'VIGENTE', function($query) use ($today) {
            $query->where('FechaInicio', '<=', $today)
                  ->where('FechaFin', '>=', $today);
        })
        ->when($estatus == 'PROXIMAMENTE', function($query) use ($today) {
            $query->where('FechaInicio', '>', $today);
        })
        ->when($estatus == 'CADUCADA', function($query) use ($today) {
            $query->where('FechaFin', '<', $today);
        })
        ->orderBy('FechaInicio', 'desc')
        ->get();
        
        return view('monitoreo.index', [
            'convocatorias' => $convocatorias,
            'estatus' => $estatus
        ]);
    }

    public function show($id)
    {
        $convocatoria = Convocatoria::with([
            'categoria',
            'estatus',
            'proyectosConvocatoria.proyecto.descripcion',
            'proyectosConvocatoria.proyecto.lider.carrera'
        ])->findOrFail($id);

        $proyectos = $convocatoria->proyectosConvocatoria;

        return view('monitoreo.show', compact('convocatoria', 'proyectos'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoreoController extends Controller
{
     public function monitoreo(Request $request)
    {
        $estatus = $request->input('estatus', 'TODAS');
        
        $query = Convocatoria::with(['categoria', 'estatus'])
            ->where('Estatus', 1);
            
        if ($estatus !== 'TODAS') {
            $query->whereHas('estatus', function($q) use ($estatus) {
                $q->where('Descripcion', $estatus);
            });
        }
        
        $convocatorias = $query->orderBy('FechaInicio', 'desc')->get();
        
        return view('monitoreo.index', compact('convocatorias', 'estatus'));
    }

    public function detalleConvocatoria($id)
    {
        $convocatoria = Convocatoria::with(['categoria', 'estatus'])
            ->findOrFail($id);
            
        $proyectos = ProyectoConvocatoria::with([
                'proyecto', 
                'proyecto.lider', 
                'proyecto.lider.carrera',
                'proyecto.categoria',
                'proyecto.descripcion'
            ])
            ->where('IdConvocatoria', $id)
            ->where('Estatus', 1)
            ->get();
            
        return view('monitoreo.detalle', compact('convocatoria', 'proyectos'));
    }
}

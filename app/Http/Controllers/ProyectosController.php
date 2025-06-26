<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\TblUsuario;
use App\Models\Categoria;
use App\Models\Estatus;
use App\Models\DescripcionProyecto;
use App\Models\ProyectoEliminado;
use Illuminate\Support\Facades\DB;

class ProyectosController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::with(['lider', 'categoria', 'descripcion'])->get();
        return view('proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        $lideres = TblUsuario::where('IdRol', 2)->get();
        $categorias = Categoria::where('Estatus', 1)->get();
        $estatus = Estatus::where('Catalogo', 'Proyectos')->get();
        $asesores = TblUsuario::where('IdRol', 5)->get();

        return view('proyectos.create', compact('lideres', 'categorias', 'estatus', 'asesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'IdUsuarioLider' => 'required|exists:tbll_usuario,IdUsuario',
            'IdCategoria' => 'required|exists:cat_categoria,IdCategoria',
            'IdStatus' => 'required|exists:cat_estatus,IdStatus',
            'Nombre' => 'required|string|max:255',
            'PropValor' => 'required|string|max:255',
            'Introduccion' => 'required|string',
            'Justificacion' => 'required|string',
            'Descripcion' => 'required|string',
            'ObjsGrals' => 'required|string',
            'ObjsEspec' => 'required|string',
            'EdoArte' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
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
                'IdStatus' => $request->IdStatus,
                'FechaAlta' => now(),
                'IdUsuarioAlta' => auth()->id() ?? 1,
            ]);

            // Crear el proyecto
            $proyecto = Proyecto::create([
                'IdUsuarioLider' => $request->IdUsuarioLider,
                'IdCategoria' => $request->IdCategoria,
                'IdDescripcion' => $descripcion->IdDescProyecto,
                'FechaAlta' => now(),
                'FechaMod' => now(),
                'IdUsuarioMod' => auth()->id() ?? 1,
            ]);

            DB::commit();

            return redirect()->route('proyectos.index')->with('success', 'Proyecto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear el proyecto: ' . $e->getMessage());
        }
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
        $asesores = TblUsuario::where('IdRol', 5)->get();

        return view('proyectos.edit', compact('proyecto', 'lideres', 'categorias', 'estatus', 'asesores'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'IdUsuarioLider' => 'required|exists:tbl_usuario,IdUsuario',
            'IdCategoria' => 'required|exists:cat_categoria,IdCategoria',
            'IdStatus' => 'required|exists:cat_estatus,IdStatus',
            'Nombre' => 'required|string|max:255',
            'PropValor' => 'required|string|max:255',
            'Introduccion' => 'required|string',
            'Justificacion' => 'required|string',
            'Descripcion' => 'required|string',
            'ObjsGrals' => 'required|string',
            'ObjsEspec' => 'required|string',
            'EdoArte' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $proyecto = Proyecto::findOrFail($id);

            // Actualizar el proyecto
            $proyecto->update([
                'IdUsuarioLider' => $request->IdUsuarioLider,
                'IdCategoria' => $request->IdCategoria,
                'FechaMod' => now(),
                'IdUsuarioMod' => auth()->id() ?? 1,
            ]);

            // Actualizar la descripción
            $proyecto->descripcion->update([
                'Nombre' => $request->Nombre,
                'PropValor' => $request->PropValor,
                'Introduccion' => $request->Introduccion,
                'Justificacion' => $request->Justificacion,
                'Descripcion' => $request->Descripcion,
                'ObjsGrals' => $request->ObjsGrals,
                'ObjsEspec' => $request->ObjsEspec,
                'EdoArte' => $request->EdoArte,
                'IdStatus' => $request->IdStatus,
                'FechaMod' => now(),
                'IdUsuarioMod' => auth()->id() ?? 1,
            ]);

            DB::commit();

            return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $proyecto = Proyecto::findOrFail($id);
            
            // Registrar en proyectos eliminados
            ProyectoEliminados::create([
                'IdProyecto' => $proyecto->IdProyecto,
                'IdUsuario' => auth()->id() ?? 1,
                'FechaElimina' => now(),
            ]);

            // Eliminar el proyecto
            $proyecto->delete();

            DB::commit();

            return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
        }
    }
}
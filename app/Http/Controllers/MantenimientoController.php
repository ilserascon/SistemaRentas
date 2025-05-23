<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Maquinaria;
use App\Models\Falla;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = Mantenimiento::with(['falla.maquinaria', 'falla.tipoFalla', 'falla.clasificacionFalla'])
            ->where('activo', true)  // solo mantenimientos activos
            ->whereHas('falla.maquinaria', function($query) {
                $query->where('id_estatus_maquinaria', 3);
            })
            ->paginate(10);

        return view('mantenimiento.index', compact('mantenimientos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_falla' => 'required|exists:fallas,id',
        ]);

        // Obtener la falla y su maquinaria
        $falla = Falla::findOrFail($request->id_falla);

        // Verificar si ya existe un mantenimiento activo para esta maquinaria
        $existeMantenimiento = Mantenimiento::where('activo', true)
            ->whereHas('falla', function($query) use ($falla) {
                $query->where('id_maquinaria', $falla->id_maquinaria);
            })
            ->first();

        if ($existeMantenimiento) {
            return redirect()->route('mantenimiento.index')->with('error', 'Ya existe un mantenimiento activo para esta maquinaria.');
        }

        // Verificar si ya existe un mantenimiento para esta falla
        $existeMantenimientoFalla = Mantenimiento::where('id_falla', $request->id_falla)->first();

        if ($existeMantenimientoFalla) {
            return redirect()->route('mantenimiento.index')->with('error', 'Ya existe un mantenimiento registrado para esta falla.');
        }

        Mantenimiento::create($request->only('id_falla'));

        return redirect()->route('mantenimiento.index')->with('success', 'Mantenimiento creado correctamente.');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'id_falla' => 'required|exists:fallas,id',
        ]);

        $mantenimiento = Mantenimiento::findOrFail($id);
        $mantenimiento->update($request->only('id_falla'));

        return redirect()->route('mantenimiento.index')->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        $mantenimiento->delete();

        return redirect()->route('mantenimiento.index')->with('success', 'Mantenimiento eliminado correctamente.');
    }

    
    public function terminar($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);

        // Cambiar el estado de la maquinaria a "Normal"
        $maquinaria->id_estatus_maquinaria = 1;
        $maquinaria->save();

        // Buscar mantenimiento activo para esta maquinaria y marcarlo como inactivo
        $mantenimientoActivo = Mantenimiento::where('activo', true)
            ->whereHas('falla', function($query) use ($maquinaria) {
                $query->where('id_maquinaria', $maquinaria->id);
            })
            ->first();

        if ($mantenimientoActivo) {
            $mantenimientoActivo->activo = false;
            $mantenimientoActivo->save();
        }

        return redirect()->route('mantenimiento.index')->with('success', 'La maquinaria ha sido marcada como terminada y disponible.');
    }

}
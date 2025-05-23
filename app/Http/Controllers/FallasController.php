<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use App\Models\Maquinaria;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class FallasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_tipo_falla' => 'required|exists:tipo_fallas,id',
            'id_clasificacion_falla' => 'required|exists:clasificacion_fallas,id',
            'id_maquinaria' => 'required|exists:maquinaria,id',
            'id_pedido' => 'required|exists:pedido,id',
        ]);

        // Verificar si ya existe una falla activa para esta maquinaria
        $fallaExistente = Falla::where('id_maquinaria', $request->id_maquinaria)
            ->where('activa', true)
            ->first();

        if ($fallaExistente) {
            return redirect()->route('pedidos.index')->with('error', 'Esta maquinaria ya tiene una falla activa.');
        }

        // Crear nueva falla con "activa = true"
        Falla::create([
            'id_tipo_falla' => $request->id_tipo_falla,
            'id_clasificacion_falla' => $request->id_clasificacion_falla,
            'id_maquinaria' => $request->id_maquinaria,
            'id_pedido' => $request->id_pedido,
            'activa' => true,
        ]);

        // Cambiar estatus de la maquinaria a "En falla"
        $maquinaria = Maquinaria::find($request->id_maquinaria);
        if ($maquinaria) {
            $maquinaria->id_estatus_maquinaria = 2;
            $maquinaria->save();
        }

        return redirect()->route('pedidos.index')->with('success', 'Falla registrada correctamente.');
    }

    public function index()
    {
        $fallas = Falla::with(['tipoFalla', 'clasificacionFalla', 'maquinaria', 'pedido'])
            ->where('activa', true)
            ->whereHas('maquinaria', function($query) {
                $query->where('id_estatus_maquinaria', 2);
            })
            ->get();

        return view('fallas.index', compact('fallas'));
    }

    public function Mantenimiento($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        $maquinaria->id_estatus_maquinaria = 3; // Mantenimiento
        $maquinaria->save();

        // Obtener la falla activa
        $falla = Falla::where('id_maquinaria', $maquinaria->id)
            ->where('activa', true)
            ->latest()
            ->first();

        if ($falla) {
            // Cerrar la falla
            $falla->activa = false;
            $falla->save();

            // Registrar mantenimiento
            Mantenimiento::create([
                'id_falla' => $falla->id,
            ]);
        }

        return redirect()->route('fallas.index')->with('success', 'La maquinaria fue enviada a mantenimiento.');
    }
}

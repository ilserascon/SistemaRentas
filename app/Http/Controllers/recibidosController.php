<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Maquinaria;

class RecibidosController extends Controller
{
    public function index()
    {
        // Obtiene los pedidos con estatus "En Renta" (4) o "Terminado" (5)
        $pedidos = Pedido::whereIn('id_estatus_pedido', [4, 5])->get();

        return view('recibidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);

        return view('recibidos.show', compact('pedido'));
    }

    public function recibir(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'foto' => 'required|string',
            'firma' => 'required',
        ]);

        // Guardar la imagen base64 como archivo
        $data = $request->input('foto');
        $data = preg_replace('/^data:image\/\w+;base64,/', '', $data);
        $data = base64_decode($data);
        $nombreArchivo = 'foto_' . time() . '.png';
        \Storage::disk('public')->put('fotos/' . $nombreArchivo, $data);
        $fotoPath = 'fotos/' . $nombreArchivo;

        $pedido->update([
            'foto' => $fotoPath,
            'firma' => $request->input('firma'),
            'id_estatus_pedido' => 5, // Cambia el estatus a "Terminado"
        ]);

        // Cambiar estatus de la maquinaria a "Mantenimiento" si hay maquinaria asignada
        if ($pedido->id_maquinaria) {
            $maquinaria = Maquinaria::find($pedido->id_maquinaria);
            if ($maquinaria) {
                $maquinaria->id_estatus_maquinaria = 3; // 3 = Mantenimiento
                $maquinaria->save();

                // Buscar la última falla activa de la maquinaria
                $falla = \App\Models\Falla::where('id_maquinaria', $maquinaria->id)
                    ->where('activa', true)
                    ->latest()
                    ->first();

                if ($falla) {
                    // Marcar la falla como inactiva
                    $falla->activa = false;
                    $falla->save();
                } else {
                    // Si no hay falla activa, crea una nueva
                    $falla = new \App\Models\Falla();
                    $falla->id_tipo_falla = 1;
                    $falla->id_clasificacion_falla = 1;
                    $falla->id_maquinaria = $maquinaria->id;
                    $falla->id_pedido = $pedido->id;
                    $falla->activa = false;
                    $falla->save();
                }

                // Crear el mantenimiento relacionado a esa falla
                $mantenimiento = new \App\Models\Mantenimiento();
                $mantenimiento->id_falla = $falla->id;
                $mantenimiento->activo = true;
                $mantenimiento->save();
            }
        }

        return redirect()->route('recibidos.index')->with('success', 'Pedido recibido correctamente.');
    }
}
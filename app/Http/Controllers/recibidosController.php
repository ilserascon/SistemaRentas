<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

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

        return redirect()->route('recibidos.index')->with('success', 'Pedido recibido correctamente.');
    }
}
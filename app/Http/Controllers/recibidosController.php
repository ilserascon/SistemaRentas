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
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'firma' => 'required',
        ]);

        $fotoPath = $request->file('foto')->store('fotos', 'public');

        $pedido->update([
            'foto' => $fotoPath,
            'firma' => $request->input('firma'),
            'id_estatus_pedido' => 5, // Cambia el estatus a "Terminado"
        ]);

        return redirect()->route('recibidos.index')->with('success', 'Pedido recibido correctamente.');
    }
}
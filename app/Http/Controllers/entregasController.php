<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class EntregasController extends Controller
{
    public function index()
    {
        $pedidosEnEntrega = Pedido::with('estatusPedido')
            ->where('id_estatus_pedido', 3) // 3 corresponde a "En Entrega"
            ->get();

        $pedidosCancelados = Pedido::with('estatusPedido')
            ->where('id_estatus_pedido', 6) // 6 corresponde a "Cancelado"
            ->get();

        $pedidos = $pedidosEnEntrega->merge($pedidosCancelados);

        return view('entregas.index', compact('pedidos'));
    }

    public function showEntregar($id)
    {
        $pedido = Pedido::where('id', $id)->firstOrFail();

        return view('entregas.entregar', compact('pedido'));
    }

    public function entregar(Request $request, $id)
    {
        $pedido = Pedido::where('id', $id)->firstOrFail();

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'firma' => 'required',
        ]);

        $fotoPath = $request->file('foto')->store('fotos', 'public');

        $pedido->update([
            'foto' => $fotoPath,
            'firma' => $request->input('firma'),
            'id_estatus_pedido' => 4, // 4 corresponde a "En Renta"
        ]);

        return redirect()->route('entregas.index')->with('success', 'Entrega realizada correctamente.');
    }

    public function cancelar($id)
    {
        $pedido = Pedido::where('id', $id)->firstOrFail();

        $pedido->update(['id_estatus_pedido' => 6]); // 6 corresponde a "Cancelado"

        return redirect()->route('entregas.index')->with('success', 'Entrega cancelada correctamente.');
    }
}
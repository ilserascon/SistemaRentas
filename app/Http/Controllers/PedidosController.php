<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Maquinaria;
use App\Models\Repartidor;
use App\Models\EstatusPedido;
use App\Models\TipoMaquinaria;
use App\Models\User;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los pedidos no borrados
        $query = Pedido::where('borrado', 0);

        // Filtrado por estatus (opcional)
        if ($request->filled('estatus')) {
            $query->where('id_estatus_pedido', $request->estatus);
        }

        // Cargar los pedidos con sus relaciones
        $pedidos = $query->with(['cliente', 'tipoMaquinaria', 'maquinaria', 'repartidor', 'estatusPedido', 'usuario'])->get();

        // Datos necesarios para el filtro y vista
        $repartidores = Repartidor::all();
        $maquinarias = Maquinaria::all();
        $maquinariasEnRenta = Pedido::where('id_estatus_pedido', 2)->pluck('id_maquinaria')->toArray();
        $estatusPedidos = EstatusPedido::all();

        return view('pedidos.index', compact('pedidos', 'repartidores', 'maquinarias', 'maquinariasEnRenta', 'estatusPedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $maquinarias = Maquinaria::all();
        $repartidores = Repartidor::all();
        $estatusPedidos = EstatusPedido::all();
        $tipoMaquinarias = TipoMaquinaria::all();
        $users = User::all();

        return view('pedidos.create', compact('clientes', 'maquinarias', 'repartidores', 'estatusPedidos', 'tipoMaquinarias', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|string|max:191|unique:pedido,folio',
            'fecha_entrega_solicitada' => 'required|date',
            'fecha_devolucion_solicitada' => 'required|date',
            'observacion' => 'nullable|string|max:191',
            'id_cliente' => 'required|integer|exists:clientes,id',
            'ubicacion_url' => 'required|url|max:65535',
            'id_tipo_maquinaria' => 'required|integer|exists:tipo_maquinaria,id',
        ]);

        $data = $request->all();
        $data['id_usuario'] = auth()->id(); 
        $data['id_estatus_pedido'] = 1;

        Pedido::create($data);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    public function delete($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->id_estatus_pedido = 6; // Estatus "borrado"
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Estatus de pedido cambiado exitosamente.');
    }

    public function asignar(Request $request, $id)
    {
        $request->validate([
            'id_maquinaria' => 'nullable|integer|exists:maquinaria,id',
            'id_repartidor' => 'nullable|integer|exists:repartidores,id',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->id_maquinaria = $request->id_maquinaria;
        $pedido->id_repartidor = $request->id_repartidor;
        $pedido->id_estatus_pedido = 2; // Asignado
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido asignado exitosamente.');
    }

    public function entregar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->id_estatus_pedido = 3; // En entrega
        $pedido->fecha_en_entrega = now();
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'El pedido ha sido marcado como "En entrega".');
    }
}


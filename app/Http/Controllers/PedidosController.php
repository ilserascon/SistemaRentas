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
        $pedidos = $query->with(['cliente', 'tipoMaquinaria', 'maquinaria', 'repartidor', 'estatusPedido', 'usuario'])->paginate(10);

        // Obtener todos los repartidores
        $repartidores = Repartidor::all();

        // Obtener todas las maquinarias DISPONIBLES (estatus 1) y NO borradas
        $maquinarias = Maquinaria::where('id_estatus_maquinaria', 1)
            ->where('borrado', 0)
            ->get();

        // Obtener IDs de maquinarias que están en pedidos en renta
        $maquinariasEnRenta = Pedido::where('id_estatus_pedido', 2) // 2 = En renta
            ->pluck('id_maquinaria')
            ->toArray();

        // Obtener todos los estatus de pedidos
        $estatusPedidos = EstatusPedido::all();

        return view('pedidos.index', compact('pedidos', 'repartidores', 'maquinarias', 'maquinariasEnRenta', 'estatusPedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $maquinarias = Maquinaria::where('id_estatus_maquinaria', 1)
            ->where('borrado', 0)
            ->get();
        $repartidores = Repartidor::all();
        $estatusPedidos = EstatusPedido::all();
        $tipoMaquinarias = TipoMaquinaria::all();
        $users = User::all();
        return view('pedidos.create', compact('clientes', 'maquinarias', 'repartidores', 'estatusPedidos', 'tipoMaquinarias', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
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

        $pedido = Pedido::create($data);
        $pedido->folio = $pedido->id . '-' . date('Y');
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    public function delete(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->id_estatus_pedido = 6;
        $pedido->observacion = $request->input('observacion');
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Estatus de pedido cambiado exitosamente.');
    }

    public function asignar(Request $request, $id)
    {
        $request->validate([
            'id_maquinaria' => 'required|integer|exists:maquinaria,id',
            'id_repartidor' => 'required|integer|exists:repartidores,id',
        ]);

        if ($request->id_maquinaria) {
            $maquinaria = Maquinaria::find($request->id_maquinaria);
            if ($maquinaria && $maquinaria->id_estatus_maquinaria == 2) {
                return redirect()->back()->with('error', 'No puedes asignar una maquinaria que está en falla.');
            }
        }

        // Buscar el pedido por su ID
        $pedido = Pedido::findOrFail($id);

        // Actualizar los campos de asignación
        $pedido->id_maquinaria = $request->id_maquinaria;
        $pedido->id_repartidor = $request->id_repartidor;
        $pedido->id_estatus_pedido = 2; // Cambiar el estatus a "Asignado"
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido asignado exitosamente.');
    }

    public function entregar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->id_estatus_pedido = 3;
        $pedido->fecha_en_entrega = now();
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'El pedido ha sido marcado como "En entrega".');
    }
}

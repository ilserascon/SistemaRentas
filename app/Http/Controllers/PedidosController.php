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
        // $pedidos = Pedido::where('borrado', 0)->get();
        $query = Pedido::where('borrado', 0);

        // Filtrado por estatus
        if ($request->filled('estatus')) {
            $query->where('id_estatus_pedido', $request->estatus);
        }

        // Cargar la relación de EstatusPedido con los pedidos
        $pedidos = $query->with('estatusPedido')->get();
        $estatusPedidos = EstatusPedido::all();

        return view('pedidos.index', compact('pedidos', 'estatusPedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $maquinarias = Maquinaria::all();
        $repartidores = Repartidor::all();
        $estatusPedidos = EstatusPedido::all();
        $tipoMaquinarias = TipoMaquinaria::all();
        $users= User::all();
        return view('pedidos.create',compact('clientes', 'maquinarias', 'repartidores', 'estatusPedidos', 'tipoMaquinarias', 'users'));
    }

    public function store(Request $request) {
        $request->validate([
            'folio' => 'required|string|max:191',
            'fecha_en_entrega' => 'required|date',
            'fecha_entrega_solicitada' => 'required|date',
            'fecha_devolucion_solicitada' => 'required|date',
            'observacion' => 'nullable|string|max:191',
            'id_cliente' => 'required|integer|exists:clientes,id',
            'id_maquinaria' => 'nullable|integer|exists:maquinaria,id',
            'id_repartidor' => 'nullable|integer|exists:repartidores,id',
            'id_usuario' => 'required|integer|exists:users,id',
            'id_tipo_maquinaria' => 'required|integer|exists:tipo_maquinaria,id', 
        ]);

        $data = $request->all();
        $data['id_estatus_pedido'] = 1;
    
        Pedido::create($data);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    public function edit($id){
        // Buscar el pedido por su ID
    $pedido = Pedido::findOrFail($id);

    // Obtener los datos necesarios para los selectores
    $clientes = Cliente::all();
    $maquinarias = Maquinaria::all();
    $repartidores = Repartidor::all();
    $estatusPedidos = EstatusPedido::all();
    $tipoMaquinarias = TipoMaquinaria::all();
    $users = User::all();

    // Retornar la vista de edición con los datos
    return view('pedidos.edit', compact('pedido', 'clientes', 'maquinarias', 'repartidores', 'estatusPedidos', 'tipoMaquinarias', 'users'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'folio' => 'required|string|max:191',
            'fecha_en_entrega' => 'required|date',
            'fecha_entrega_solicitada' => 'required|date',
            'fecha_devolucion_solicitada' => 'required|date',
            'observacion' => 'nullable|string|max:191',
            'id_cliente' => 'required|integer|exists:clientes,id',
            'id_maquinaria' => 'nullable|integer|exists:maquinaria,id',
            'id_repartidor' => 'nullable|integer|exists:repartidores,id',
            'id_estatus_pedido' => 'required|integer|exists:estatus_pedido,id',
            'id_usuario' => 'required|integer|exists:users,id',
            'id_tipo_maquinaria' => 'required|integer|exists:tipo_maquinaria,id', 
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente.');
    }
    public function delete($id){
        $pedido = Pedido::findOrFail($id);
        $pedido->id_estatus_pedido = 6; // Cambia el estado a borrado
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Estatus de pedido cambiado exitosamente.');
    }

    
    public function asignar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->id_estatus_pedido = 2; // Cambiar el estatus a "Asignado"
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido asignado exitosamente.');
    }
}

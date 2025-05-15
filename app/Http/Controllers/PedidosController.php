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
    public function index()
    {
        // Obtiene los pedidos que no están marcados como borrados
        $pedidos = Pedido::where('borrado', 0)->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        // Obtiene los datos necesarios para el formulario de creación
        $clientes = Cliente::all();
        $maquinarias = Maquinaria::all();
        $repartidores = Repartidor::all(); // Si usas User como repartidores, cámbialo
        $estatusPedidos = EstatusPedido::all();
        $tipoMaquinarias = TipoMaquinaria::all();
        $users = User::all(); // Para id_usuario
        return view('pedidos.create', compact('clientes', 'maquinarias', 'repartidores', 'estatusPedidos', 'tipoMaquinarias', 'users'));
    }

    public function store(Request $request)
    {
        // Valida los datos enviados desde el formulario
        $request->validate([
            'folio' => 'required|string|max:191|unique:pedido,folio',
            'fecha_en_entrega' => 'required|date',
            'fecha_entrega_solicitada' => 'required|date',
            'fecha_devolucion_solicitada' => 'required|date',
            'observacion' => 'nullable|string|max:191',
            'id_cliente' => 'required|integer|exists:clientes,id',
            'id_maquinaria' => 'required|integer|exists:maquinaria,id',
            'id_repartidor' => 'required|integer|exists:repartidores,id', // O users si es así
            'id_estatus_pedido' => 'required|integer|exists:estatus_pedido,id',
            'id_usuario' => 'required|integer|exists:users,id',
            'id_tipo_maquinaria' => 'required|integer|exists:tipo_maquinaria,id',
        ]);

        // Crea un nuevo pedido con los datos validados
        Pedido::create($request->only([
            'folio',
            'fecha_en_entrega',
            'fecha_entrega_solicitada',
            'fecha_devolucion_solicitada',
            'observacion',
            'id_cliente',
            'id_maquinaria',
            'id_repartidor',
            'id_estatus_pedido',
            'id_usuario',
            'id_tipo_maquinaria',
        ]));

        // Redirige a la lista de pedidos con un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }
}
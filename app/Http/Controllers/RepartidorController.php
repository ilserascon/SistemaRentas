<?php

namespace App\Http\Controllers;

use App\Models\Repartidor;
use App\Models\Pedido;
use Illuminate\Http\Request;

class RepartidorController extends Controller
{
    // Muestra la lista de repartidores que no han sido eliminados lógicamente (borrado = 0)
    public function index()
    {
        // Solo se obtienen los repartidores cuyo campo 'borrado' es 0
        $repartidores = Repartidor::where('borrado', 0)->paginate(10); 
        return view('repartidores.index', compact('repartidores'));
    }

    // Muestra el formulario para crear un nuevo repartidor
    public function create()
    {
        return view('repartidores.create');
    }

    // Almacena un nuevo repartidor
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:repartidores,email',
        ]);

        // Crear el repartidor en la base de datos
        Repartidor::create($request->only(['nombre', 'telefono', 'email']));

        // Redirigir con un mensaje de éxito
        return redirect()->route('repartidores.index')->with('success', 'Repartidor creado correctamente.');
    }

    // Muestra el formulario para editar un repartidor
    public function edit($id)
    {
        // Buscar el repartidor por ID, si no existe, lanzará una excepción
        $repartidor = Repartidor::findOrFail($id);
        return view('repartidores.edit', compact('repartidor'));
    }

    // Actualiza los datos de un repartidor
    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:repartidores,email,' . $id, // Permite actualizar el email sin que sea único si es el mismo
        ]);

        // Buscar el repartidor y actualizar sus datos
        $repartidor = Repartidor::findOrFail($id);
        $repartidor->update($request->only(['nombre', 'telefono', 'email']));

        // Redirigir con un mensaje de éxito
        return redirect()->route('repartidores.index')->with('success', 'Repartidor actualizado correctamente.');
    }

    // Elimina un repartidor lógicamente (marca el campo "borrado" a 1)
    public function destroy($id)
    {
        // Buscar el repartidor por ID
        $repartidor = Repartidor::findOrFail($id);

        // Marcar el repartidor como eliminado (borrado lógico)
        $repartidor->borrado = 1;
        $repartidor->save();

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('repartidores.index')->with('success', 'Repartidor eliminado correctamente.');
    }

    public function show(Request $request, $id)
    {
        $repartidor = Repartidor::findOrFail($id);

        $query = Pedido::where('id_repartidor', $id)
            ->where('borrado', 0);

        // Filtro por estatus si viene en la petición
        if ($request->filled('estatus')) {
            $query->where('id_estatus_pedido', $request->estatus);
        }

        $pedidos = $query->with(['cliente', 'tipoMaquinaria', 'maquinaria', 'repartidor', 'estatusPedido', 'usuario'])
            ->paginate(10);

        // Puedes pasar los estatus disponibles a la vista si lo necesitas
        $estatusPedidos = \App\Models\EstatusPedido::all();

        return view('repartidores.pedidos', compact('repartidor', 'pedidos', 'estatusPedidos'));
    }
}

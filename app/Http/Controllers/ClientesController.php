<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Pedido;

class ClientesController extends Controller
{

    public function index(Request $request)
    {
        $query = Cliente::where('borrado', 0);

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('rfc')) {
            $query->where('rfc', 'like', '%' . $request->rfc . '%');
        }

        $clientes = $query->get();

        return view('clientes.index', compact('clientes'));
    }

    public function create() {
        return view('clientes.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|max:255',
            'rfc' => 'required|max:20|unique:clientes,rfc',
            'razon_social' => 'required|max:255',
            'telefono' => 'required|max:20',
            'email' => 'required|email|max:255|unique:clientes,email',
            'direccion' => 'required|max:255',
            'codigo_postal' => 'required|max:15',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit($id) {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nombre' => 'required|max:255',
            'rfc' => 'required|max:20|unique:clientes,rfc,' . $id,
            'razon_social' => 'required|max:255',
            'telefono' => 'required|max:20',
            'email' => 'required|email|max:255|unique:clientes,email,' . $id,
            'direccion' => 'required|max:255',
            'codigo_postal' => 'required|max:15'
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function delete($id) {
        $cliente = Cliente::findOrFail($id);
        $cliente->borrado = 1;
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
    



    public function pedidos($id, Request $request)
{
    $cliente = Cliente::findOrFail($id);
    $estatus = $request->input('estatus');

    $pedidos = Pedido::with(['usuario', 'repartidor', 'tipoMaquinaria', 'maquinaria', 'estatusPedido'])
        ->where('id_cliente', $id)
        ->when($estatus, function ($query, $estatus) {
            $query->whereHas('estatusPedido', function ($q) use ($estatus) {
                $q->where('descripcion', $estatus);
            });
        })
        ->get();

    return view('clientes.pedidos', compact('cliente', 'pedidos'));
}
}




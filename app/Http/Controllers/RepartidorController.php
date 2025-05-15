<?php

namespace App\Http\Controllers;

use App\Models\Repartidor;
use Illuminate\Http\Request;

class RepartidorController extends Controller
{
    public function index()
    {
        $repartidores = Repartidor::where('borrado', 0)->get(); 
        return view('repartidores.index', compact('repartidores'));
    }

    public function create()
    {
        return view('repartidores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:repartidores,email',
        ]);

        Repartidor::create($request->only(['nombre', 'telefono', 'email']));

        return redirect()->route('repartidores.index')->with('success', 'Repartidor creado correctamente.');
    }

    public function edit($id)
    {
        $repartidor = Repartidor::findOrFail($id);
        return view('repartidores.edit', compact('repartidor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:repartidores,email,' . $id, // Permite actualizar el email sin que sea único si es el mismo
        ]);

        $repartidor = Repartidor::findOrFail($id);
        $repartidor->update($request->only(['nombre', 'telefono', 'email']));

        return redirect()->route('repartidores.index')->with('success', 'Repartidor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $repartidor = Repartidor::findOrFail($id);

        $repartidor->borrado = 1;
        $repartidor->save();

        return redirect()->route('repartidores.index')->with('success', 'Repartidor eliminado correctamente.');
    }
}
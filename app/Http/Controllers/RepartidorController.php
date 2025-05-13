<?php

namespace App\Http\Controllers;

use App\Models\Repartidor;
use Illuminate\Http\Request;

class RepartidorController extends Controller
{
    // Muestra la lista de repartidores que no han sido eliminados lógicamente (borrado = 0)
    public function index()
    {
        // Solo se obtienen los repartidores cuyo campo 'borrado' es 0
        $repartidores = Repartidor::where('borrado', 0)->get(); 
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
}

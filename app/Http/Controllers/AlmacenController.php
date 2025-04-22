<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::where('borrado', 0)->get();
        return view('almacen.index', compact('almacenes'));
    }

    public function create()
    {
        return view('almacen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'ubicacion' => 'required',
        ]);

        Almacen::create($request->all());

        return redirect()->route('almacen.index')->with('success', 'Almacén creado correctamente');
    }

    public function edit(Almacen $almacen)
    {
        return view('almacen.edit', compact('almacen'));
    }

    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required',
            'ubicacion' => 'required',
        ]);

        $almacen->update($request->all());

        return redirect()->route('almacen.index')->with('success', 'Almacén actualizado correctamente');
    }

    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->borrado = 1;
        $almacen->save();

        return redirect()->route('almacen.index')->with('success', 'Almacén eliminado correctamente.');
    }
}

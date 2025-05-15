<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use App\Models\TipoMaquinaria;
use App\Models\Almacen;
use Illuminate\Http\Request;

class MaquinariaController extends Controller
{
    public function index(Request $request)
    {
        $query = Maquinaria::with('tipoMaquinaria') // Cargar la relación
                    ->where('borrado', false);

        if ($request->filled('numero_serie')) {
            $query->where('numero_serie', 'like', '%' . $request->numero_serie . '%');
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $maquinarias = $query->get();

        return view('maquinaria.index', compact('maquinarias'));
    }

    public function create()
    {
        $tipos_maquinaria = TipoMaquinaria::all();
        $almacenes = Almacen::all();
        return view('maquinaria.create', compact('tipos_maquinaria', 'almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'numero_serie' => 'required|string|unique:maquinaria,numero_serie',
            'modelo' => 'required|string',
            'descripcion' => 'nullable|string',
            'id_tipo_maquinaria' => 'required|exists:tipo_maquinaria,id',
            'id_almacen' => 'required|exists:almacen,id',
        ]);

        Maquinaria::create($request->all());

        return redirect()->route('maquinaria.index');
    }

    public function edit($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        $tipos_maquinaria = TipoMaquinaria::all();
        $almacenes = Almacen::all();
        return view('maquinaria.edit', compact('maquinaria', 'tipos_maquinaria', 'almacenes'));
    }

    public function update(Request $request, $id)
    {
        $maquinaria = Maquinaria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string',
            'numero_serie' => 'required|string|unique:maquinaria,numero_serie,' . $maquinaria->id,
            'modelo' => 'required|string',
            'descripcion' => 'nullable|string',
            'id_tipo_maquinaria' => 'required|exists:tipo_maquinaria,id',
            'id_almacen' => 'required|exists:almacen,id',
        ]);

        $maquinaria->update($request->all());

        return redirect()->route('maquinaria.index');
    }

    public function destroy($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        $maquinaria->update(['borrado' => true]);

        return redirect()->route('maquinaria.index');
    }
}
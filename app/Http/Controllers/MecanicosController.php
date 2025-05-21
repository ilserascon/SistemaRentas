<?php

namespace App\Http\Controllers;

use App\Models\Mecanico;
use Illuminate\Http\Request;

class MecanicosController extends Controller
{
    public function index(Request $request)
    {
        $query = Mecanico::where('borrado', false);

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $mecanicos = $query->paginate(10);

        return view('mecanicos.index', compact('mecanicos'));
    }

    public function create()
    {
        return view('mecanicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:mecanicos,correo',
            'celular' => 'required|string|max:15',
        ]);

        Mecanico::create($request->all());
        return redirect()->route('mecanicos.index')->with('success', 'Mecánico creado correctamente.');
    }

    public function edit($id)
    {
        $mecanico = Mecanico::findOrFail($id);
        return view('mecanicos.edit', compact('mecanico'));
    }

    public function update(Request $request, $id)
    {
        $mecanico = Mecanico::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:mecanicos,correo,'.$id,
            'celular' => 'required|string|max:15',
        ]);

        $mecanico->update($request->all());
        return redirect()->route('mecanicos.index')->with('success', 'Mecánico actualizado correctamente.');
    }

    public function destroy($id)
    {
        $mecanico = Mecanico::findOrFail($id);
        $mecanico->update(['borrado' => true]);
        return redirect()->route('mecanicos.index')->with('success', 'Mecánico eliminado correctamente.');
    }
}
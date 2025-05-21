<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use App\Models\TipoFalla;
use App\Models\ClasificacionFalla;
use App\Models\Pedido;
use Illuminate\Http\Request;

class FallaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
    'id_tipo_falla' => 'required|exists:tipo_fallas,id',
    'id_clasificacion_falla' => 'required|exists:clasificacion_fallas,id',
    'id_maquinaria' => 'required|exists:maquinaria,id',
    'id_pedido' => 'required|exists:pedido,id', // Cambia 'pedidos' por el nombre real de tu tabla
]);

        Falla::create($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Falla registrada correctamente.');
    }

    public function index()
    {
        $fallas = Falla::with(['tipoFalla', 'clasificacionFalla', 'maquinaria', 'pedido'])->get();
        return view('fallas.index', compact('fallas'));
    }
}
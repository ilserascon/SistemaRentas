<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibido extends Model
{
    use HasFactory;

    protected $table = 'pedido'; // Nombre de la tabla en la base de datos

    protected $fillable = ['descripcion', 'foto', 'firma']; 
    public function show($id)
{
    $pedido = Recibido::findOrFail($id);

    return view('recibidos.show', compact('pedido'));
}// Campos permitidos para asignación masiva
}
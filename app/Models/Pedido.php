<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';

    protected $fillable = [
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
        'borrado',
    ];

    // Relación con el modelo EstatusPedido
    public function estatus()
    {
        return $this->belongsTo(EstatusPedido::class, 'id_estatus_pedido');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'pedido';

    protected $fillable = [
        'id_pedido',
        'id_repartidor',
        'foto',
        'firma',
        'id_estatus_pedido',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function repartidor()
    {
        return $this->belongsTo(User::class, 'id_repartidor');
    }
}
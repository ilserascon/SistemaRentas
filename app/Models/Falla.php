<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Falla extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_tipo_falla',
        'id_clasificacion_falla',
        'id_maquinaria',
        'id_pedido',
    ];

    public function tipoFalla()
    {
        return $this->belongsTo(TipoFalla::class, 'id_tipo_falla');
    }

    public function clasificacionFalla()
    {
        return $this->belongsTo(ClasificacionFalla::class, 'id_clasificacion_falla');
    }

    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'id_maquinaria');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
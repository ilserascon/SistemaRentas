<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    use HasFactory;

    protected $table = 'maquinaria'; // 👈 Soluciona el error

    protected $fillable = [
        'nombre',
        'numero_serie',
        'modelo',
        'descripcion',
        'id_tipo_maquinaria',
        'id_almacen',
        'borrado',
    ];

    // Relación con TipoMaquinaria
    public function tipoMaquinaria()
    {
        return $this->belongsTo(TipoMaquinaria::class, 'id_tipo_maquinaria');
    }

    // Relación con Almacen
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }
}

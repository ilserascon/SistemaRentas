<?php

// app/Models/Maquinaria.php

// app/Models/Maquinaria.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    use HasFactory;

    // Especificamos la tabla y los campos que no deben ser asignados masivamente
    protected $table = 'maquinaria';
    protected $fillable = [
        'nombre',
        'numero_serie',
        'modelo',
        'descripcion',
        'id_tipo_maquinaria',
        'id_almacen',
        'borrado'
    ];

    // Relación con la tabla tipo_maquinaria
    public function tipoMaquinaria()
    {
        return $this->belongsTo(TipoMaquinaria::class, 'id_tipo_maquinaria');
    }

    // Relación con la tabla almacen
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    // Para que el campo borrado sea tratado como booleano
    protected $casts = [
        'borrado' => 'boolean',
    ];
}
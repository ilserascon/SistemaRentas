<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMaquinaria extends Model
{
    use HasFactory;

    protected $table = 'tipo_maquinaria'; // 👈 Esto soluciona el error

    protected $fillable = [
        'descripcion',
    ];

    // Relación inversa (opcional)
    public function maquinarias()
    {
        return $this->hasMany(Maquinaria::class, 'id_tipo_maquinaria');
    }
}

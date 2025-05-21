<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasificacionFalla extends Model
{
    use HasFactory;

    protected $table = 'clasificacion_fallas';

    protected $fillable = [
        'descripcion',
    ];
}
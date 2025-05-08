<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre','rfc','razon_social', 'telefono', 'email', 'direccion','codigo_postal', 'borrado'];
    protected $table = 'clientes';
}

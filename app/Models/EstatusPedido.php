<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatusPedido extends Model
{
    protected $table = 'estatus_pedido';

    protected $fillable = ['descripcion'];

}

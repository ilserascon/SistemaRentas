<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    protected $table = 'repartidores';

    protected $fillable = ['nombre', 'telefono', 'email'];

    public $timestamps = true;
}
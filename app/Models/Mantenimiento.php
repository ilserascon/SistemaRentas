<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{


    use HasFactory;

    protected $table = 'mantenimiento';

    protected $fillable = [
        'id_falla',
    ];

    // Relación con Falla
    public function falla()
    {
        return $this->belongsTo(Falla::class, 'id_falla');
    }
}

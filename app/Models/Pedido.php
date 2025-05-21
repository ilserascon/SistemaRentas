<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $fillable = [
        'folio',
        'fecha_en_entrega',
        'fecha_entrega_solicitada',
        'fecha_devolucion_solicitada',
        'observacion',
        'id_usuario',
        'id_cliente',
        'id_maquinaria',
        'id_repartidor',
        'id_estatus_pedido',
        'id_tipo_maquinaria',
        'ubicacion_url',
        'borrado',];

        public function usuario()
        {
            return $this->belongsTo(User::class, 'id_usuario');
        }
        
        public function tipoMaquinaria()
        {
            return $this->belongsTo(TipoMaquinaria::class, 'id_tipo_maquinaria');
        }
        
        public function cliente()
        {
            return $this->belongsTo(Cliente::class, 'id_cliente');
        }
        
        public function maquinaria()
        {
            return $this->belongsTo(Maquinaria::class, 'id_maquinaria');
        }
        
        public function repartidor()
        {
            return $this->belongsTo(Repartidor::class, 'id_repartidor');
        }
        
        public function estatusPedido()
        {
            return $this->belongsTo(EstatusPedido::class, 'id_estatus_pedido');
        }

        public function pedidos()
        {
            return $this->hasMany(Pedido::class, 'id_estatus_pedido');
        }
}
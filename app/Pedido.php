<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos_reg';
    protected $primaryKey ='id_pedido';
    protected $guarded=[];//Desactiva la proteccion
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = 'fecha_reg';//No existe en la BD

    public function vendedor(){
    	return $this->belongsTo(Vendedor::class,'id_vendedor','id_vendedor'); //(ElModelo,KeyHijo,KeyPadre)
    	#dato
    }

    public function productos(){
    	return $this->hasMany(PedidoProducto::class,'id_pedido','id_pedido');
    }

    public function pedidosHijo(){
        return $this->hasMany(Pedido::class,'id_pedido_padre','id_pedido');
    }
}

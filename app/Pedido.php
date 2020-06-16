<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos_reg';
    protected $guarded=[];//Desactiva la proteccion
    const UPDATED_AT = null;//No existe en la BD
    const CREATED_AT = null;//No existe en la BD

    public function vendedor(){
    	return $this->belongsTo(Vendedor::class,'id_vendedor','id_vendedor'); //(ElModelo,KeyHijo,KeyPadre)
    	#dato
    }
}

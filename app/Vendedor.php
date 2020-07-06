<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $primaryKey ='id_vendedor';
    protected $guarded=[];
    const CREATED_AT = 'fecha_reg';
	const UPDATED_AT = 'fecha_act';

	
	public function usuario(){
        return $this->belongsTo(User::class,'id_usuario_vendedor','id');
    }	

	public function descuentoGeneral(){
        return $this->belongsTo(VendedorDescuentoGeneral::class,'id_vendedor','id_vendedor');
    }

    public function descuentoProductos(){
    	return $this->hasMany(VendedorDescuentoProducto::class,'id_vendedor','id_vendedor');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoMov extends Model
{
    protected $table ='productos_mov';
    protected $guarded=[];
    const CREATED_AT = 'fecha_reg';//No existe en la BD
    const UPDATED_AT = null;//No existe en la BD

	public function producto(){
        return $this->belongsTo(Producto::class,'id_producto','id_producto');
    }



}

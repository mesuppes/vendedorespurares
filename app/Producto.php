<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table ='productos_descripcion';
    protected $primaryKey ='id_producto';
    protected $guarded=[];
    const CREATED_AT = 'fecha_reg';
	const UPDATED_AT = 'fecha_act';

    public function stock(){
        return $this->belongsTo(ProductoStock::class,'id_producto','id_producto');
    }

    public function precioActual(){
        return $this->belongsTo(PrecioV::class,'id_producto','id_producto');
    }

    public function stockLote(){
        return $this->hasMany(ProductoStockLote::class,'id_producto','id_producto');
    }

    public function precio(){
    	return $this->hasMany(Precio::class,'id_producto','id_producto');
    }

    public function productoFabrica(){
        return $this->belongsTo(ProductoFabrica::class,'id_producto_produccion','id_producto');
    }
}

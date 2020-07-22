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
        return $this->belongsTo(Stockproducto::class,'id_producto','id_producto');
    }

    public function stockLote(){
        return $this->hasMany(ProductoStocklote::class,'id_producto','id_producto');
    }

    public function precio(){
    	return $this->hasMany(Precio::class,'id_producto','id_producto');
    }
}
